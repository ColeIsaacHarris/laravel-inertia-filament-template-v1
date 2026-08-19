# Laravel + Inertia + Filament Multi-Tenant Template

A starter template for multi-tenant SaaS applications.

- **Backend** — Laravel 13, PHP 8.4+, PostgreSQL
- **Tenancy** — [stancl/tenancy](https://tenancyforlaravel.com) v4, one database per tenant
- **Tenant app** — Inertia 3 + React 19 + Tailwind 4, built on [React Aria Components](https://react-spectrum.adobe.com/react-aria/)
- **Admin panel** — Filament 5 on its own subdomain, backed by a separate `admin` guard
- **Auth** — Laravel Fortify (headless), with 2FA, email verification, and password reset
- **Tooling** — Vite 8, Wayfinder, Pest 5, Pint, ESLint, Prettier, Laravel Sail

---

## Architecture

The application serves two distinct surfaces:

| | Central | Tenant |
|---|---|---|
| Domain | `ADMIN_DOMAIN` (e.g. `admin.localhost`) | one per tenant (e.g. `acme.localhost`) |
| UI | Filament admin panel | Inertia + React |
| Guard | `admin` | `web` |
| Database | the connection in `DB_DATABASE` | `tenant<id>`, created automatically |
| Migrations | `database/migrations/` | `database/migrations/tenant/` |
| Routes | registered by `AdminPanelProvider` | `routes/tenant.php` |

`bootstrap/app.php` intentionally registers **no** `web` route file — every tenant-facing
route goes through `TenancyServiceProvider::mapRoutes()`, which loads `routes/tenant.php`
inside the tenancy middleware. Fortify's routes are pulled in there too
(`Fortify::ignoreRoutes()` plus a `require` in `routes/tenant.php`) so authentication is
always tenant-scoped.

Creating a tenant fires a job pipeline (`TenancyServiceProvider`) that creates the tenant's
database, runs the tenant migrations, and seeds it.

---

## Getting started

Requires Docker and PHP 8.4+ locally.

```bash
composer run setup     # install deps, create .env, generate key, build assets
```

Add the local domains to your hosts file:

```
127.0.0.1  admin.localhost
127.0.0.1  acme.localhost
```

> Many systems already resolve `*.localhost` to loopback, in which case you can skip this.

Start everything:

```bash
composer run dev       # Sail (app + postgres + redis) + queue + logs + vite
```

Then migrate and seed the central database:

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

This creates a Filament admin — `admin@example.com` / `password`.

### Creating your first tenant

Log into the admin panel at `http://admin.localhost` and use **Tenants → New tenant**. The
subdomain field appends the base domain derived from `APP_URL`, so entering `acme` creates
`acme.localhost` and provisions the `tenantacme` database.

Or from the console:

```bash
./vendor/bin/sail artisan tinker --execute '
$t = App\Models\Tenant::create(["id" => "acme", "name" => "Acme Inc"]);
$t->domains()->create(["domain" => "acme.localhost"]);'
```

Visit `http://acme.localhost` and register, or sign in as the seeded
`test@example.com` / `password` user (seeded in `local` only).

> **Port conflicts.** If something else already owns port 80 — Laravel Herd, for instance —
> set `APP_PORT=8080` in `.env`, update `APP_URL` to match, and browse
> `http://acme.localhost:8080`.

---

## Commands

```bash
composer run dev                          # full dev environment (Sail + vite)
composer run lint                         # Pint
composer run test                         # Pint --test + the Pest suite
./vendor/bin/sail artisan test --compact  # tests only
./vendor/bin/sail artisan tenants:migrate # run tenant migrations across all tenants
./vendor/bin/sail artisan tenants:seed    # run TenantDatabaseSeeder across all tenants

npm run dev        # vite dev server
npm run build      # production assets
npm run types      # tsc --noEmit
npm run lint       # eslint --fix
npm run format     # prettier --write
```

### Testing

The suite needs a live PostgreSQL — `phpunit.xml` pins `DB_CONNECTION=pgsql` and
`DB_DATABASE=testing`, and Sail's Postgres container creates that database on first boot.
Tests will not run on SQLite.

Test traits are mapped by directory in `tests/Pest.php`:

- `tests/Concerns/WithTenancy` — runs `migrate:fresh` on central, creates a tenant and its
  database, and initializes tenancy before **each** test. Used by `Feature/Auth` and
  `Feature/Settings`.
- `tests/Concerns/WithSharedTenancy` — creates the tenant once per file and wraps each test
  in a transaction. Much faster; opt into it for read-heavy suites.
- `RefreshDatabase` — used by `Feature/Filament`, which only touches the central database.

---

## Project layout

```
app/
  Filament/          admin panel resources, pages, widgets (central only)
  Http/              controllers, middleware, form requests
  Models/            Tenant, User, Admin, Role, AuditLog
  Providers/         App, AdminPanel, Fortify, Tenancy
database/
  migrations/        central schema
  migrations/tenant/ per-tenant schema
resources/js/
  common/            portable, domain-free UI primitives and helpers
  modules/           feature-scoped code shared across pages
  pages/             Inertia pages, mirroring URL structure
routes/
  tenant.php         all tenant-facing routes
  settings.php       profile / password / 2FA / appearance
```

Frontend conventions — where a file belongs, naming, component patterns — are documented in
`.claude/skills/frontend/SKILL.md`. Architectural constraints for AI agents live in
`.ai/guidelines/project.md`, which Laravel Boost compiles into `CLAUDE.md`, `AGENTS.md`,
`.github/copilot-instructions.md`, and `.cursor/rules/`.

---

## Customizing

| What | Where |
|---|---|
| App name | `APP_NAME` in `.env` — flows to the browser title, sidebar, and auth layouts |
| Admin domain | `ADMIN_DOMAIN` in `.env` |
| Theme colors | `--primary`, `--sidebar-*` and friends in `resources/css/app.css` (`:root` and `.dark`) |
| Page background | also update the inline `<style>` in `resources/views/app.blade.php`, which must match `--background` |
| Filament colors | `AdminPanelProvider::panel()` and `FilamentColor::register()` in `AppServiceProvider` |
| Logo | `resources/js/modules/app-shell/components/app-logo-icon.tsx` and `public/favicon.*` |
| Sidebar nav | `mainNavItems` / `footerNavItems` in `resources/js/modules/app-shell/components/app-sidebar.tsx` |

---

## Deliberate version holds

- **`stancl/tenancy` is pinned to `dev-master`.** The config and providers use v4-only APIs
  (RLS policy managers, `RouteMode`, `ResourceSyncing`, `CloneRoutesAsTenant`,
  `FortifyRouteBootstrapper`). The latest stable release, v3.10, does not have them, so
  `minimum-stability` stays at `dev` with `prefer-stable: true`.
- **TypeScript stays on 5.x.** TypeScript 7 is the Go port; `typescript-eslint` still caps
  at `typescript <6.1.0`.
- **ESLint stays on 9.x.** `eslint-plugin-react` and `eslint-plugin-import` do not yet
  declare ESLint 10 support. Moving up means switching to `eslint-plugin-import-x`.
