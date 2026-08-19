# Project Guidelines

This application is a multi-tenant starter template. Read these constraints before
writing code — several of them are easy to violate silently.

## Multi-tenancy (stancl/tenancy, database-per-tenant)

- There are two distinct contexts. **Central** holds `tenants`, `domains`, and `admins`.
  **Tenant** holds `users`, `roles`, `audit_log`, and everything your application adds.
  Each tenant gets its own PostgreSQL database.
- Tenant-facing routes live in `routes/tenant.php`, registered by
  `TenancyServiceProvider::mapRoutes()`. `bootstrap/app.php` deliberately registers no
  `web` route file — do not add one and expect it to be tenant-scoped.
- Tenant migrations go in `database/migrations/tenant/` and run via
  `php artisan tenants:migrate`. Central migrations go in `database/migrations/`.
- Models that belong to a tenant need no special trait — they resolve through the active
  tenant connection. Central-only models (like `Admin`) must pin
  `protected $connection = 'central';`.
- Never assume a tenant is initialized in queued jobs or console commands unless the code
  path went through tenancy. Check `tenant()` before relying on tenant data.
- The package is pinned to `dev-master` (v4). Config and provider code use v4-only APIs
  (RLS policy managers, `RouteMode`, `ResourceSyncing`, `CloneRoutesAsTenant`,
  `FortifyRouteBootstrapper`); v3 documentation does not apply.

## Filament

- Filament is the **central** admin panel only. It is served from `config('app.admin_domain')`
  and authenticates against the `admin` guard. Do not use Filament for tenant-facing UI —
  that is Inertia + React.

## Auth

- Fortify is headless and its routes are registered manually **inside** the tenant route
  group (`Fortify::ignoreRoutes()` in `FortifyServiceProvider`, then a `require` in
  `routes/tenant.php`). Adding auth routes anywhere else puts them outside tenant scope.
- Auth views are Inertia pages mapped in `FortifyServiceProvider::configureViews()`.

## Frontend

When working on files under `resources/` (JS, CSS, or related assets), activate the
`frontend` skill. It contains the project's frontend structure, naming conventions,
component patterns, and organizational rules. The tenant app is built with
`react-aria-components` wrapped in `resources/js/common/components/` — reuse those
primitives rather than reaching for `react-aria-components` directly in a page.

## Testing

- `phpunit.xml` pins `DB_CONNECTION=pgsql`; the suite needs a live PostgreSQL and will not
  run on SQLite.
- Tenant-scoped tests use the `WithTenancy` trait (`tests/Concerns/`), mapped in
  `tests/Pest.php` by directory. `WithSharedTenancy` is a faster variant that creates the
  tenant once per file — use it for read-heavy suites.
