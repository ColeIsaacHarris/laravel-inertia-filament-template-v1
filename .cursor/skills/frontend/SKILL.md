---
name: frontend
description: "Frontend structure and conventions for the Laravel Inertia React application. Activates when creating, editing, or organizing files under resources/js or resources/css — including components, pages, modules, hooks, helpers, types, and stylesheets."
---

# Frontend Structure & Conventions

Based on [Spatie's Inertia React structure guide](https://spatie.be/blog/how-to-structure-the-frontend-of-a-laravel-inertia-react-application).

## Directory Layout (`resources/js/`)

| Directory  | Purpose |
|------------|---------|
| `common/`  | Generic, reusable code portable across projects (components, helpers, hooks, types). Not tied to any domain or feature. |
| `modules/` | Project-specific code shared across multiple pages. Organized by domain/feature (e.g., `app-shell`, `auth`, `settings`). |
| `pages/`   | Inertia page components. Mirrors URL structure. |
| `actions/` | Wayfinder-generated controller action functions. |
| `routes/`  | Wayfinder-generated named route functions. |

### Deciding `common/` vs `modules/`

If it relates to a domain or feature of this application, it belongs in `modules/`. If it is generic and theoretically portable to another project, it belongs in `common/`.

### Context-Level Organization

Each context (directory) within `common/` or `modules/` determines its own internal structure based on size:

- **Small context**: Flat files, no subdirectories needed.
- **Large context**: Organize by type with subdirectories: `components/`, `contexts/`, `helpers/`, `hooks/`, `stores/`, and a `types.ts` file.

Low-level cross-cutting utilities live at the top level of `common/` (e.g., `common/helpers/`, `common/hooks/`, `common/types/`).

## Pages

- Page component directories mirror URL structure (e.g., `/settings/profile` -> `pages/settings/profile.tsx`).
- Suffix page components with `Page` (e.g., `DashboardPage`).
- `export default` is used **only** for page components.
- Layouts live in `modules/*/layouts/` — global layouts in `modules/app-shell/layouts/`, section-specific layouts in their respective module.
- Co-locate page-specific partials in `components/`, `helpers/`, `hooks/` subdirectories within the page directory when needed.

## Naming Conventions

| Target | Casing | Examples |
|--------|--------|---------|
| All files | **kebab-case** | `button.tsx`, `user-menu-content.tsx`, `use-clipboard.ts`, `utils.ts` |
| Directories | **kebab-case** | `app-shell/`, `two-factor/` |

**Note:** Auto-generated directories (`actions/`, `routes/`) are excluded from these naming conventions — they mirror backend (PHP) naming and are managed by code generation tools like Wayfinder.

## Barrel Files

- Do not use barrel files (`index.ts` re-export files). Import directly from the source file instead.
- Auto-generated directories (`actions/`, `routes/`, `wayfinder/`) are excluded from this rule.

## React Component Conventions

### Function Declarations

- Use `function` declarations for components (not `const` arrow functions). This provides visual distinction between components and callbacks.
- Use arrow functions only for anonymous callbacks and inline expressions.

### Exports

- **Named exports** for everything — one export per file.
- **`export default`** is reserved exclusively for page components.

### Props

- Sort props alphabetically, with `className` and `children` listed last.
- Use React's `PropsWithChildren` when the component accepts children.

## Stylesheets

Single `resources/css/app.css` file. If complexity grows, split into scoped subdirectories:

```
css/
├── base/        (element-level styles)
├── components/  (component-specific styles)
├── utilities/   (utility classes)
└── app.css      (entry point)
```

## Multi-Zone Structure (if needed)

For distinct app sections (e.g., admin/client), introduce `resources/js/apps/`:

```
resources/js/
├── apps/
│   ├── admin/   (modules, pages, app.tsx)
│   └── client/  (modules, pages, app.tsx)
├── common/      (shared across all zones)
└── modules/     (shared modules across zones)
```

Each zone gets its own CSS entry point under `resources/css/<zone>/app.css`.
