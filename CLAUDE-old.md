When contributing to this codebase there are a few key points to be aware of and conventions you should follow:

- This project uses stancl/tenancy to enable multi-tenancy with a "one database per tenant" approach. It's important to be mindful of this fact when implementing code to ensure that tenant scope is respected and that code is correctly divided between the "central" and "tenant" domains. 
- This project follows various widely-adopted but technically "non-standard" Laravel conventions which should be adhered to when appropriate. These include: 
    - `DTOs` via the spatie/laravel-data package
    - `View Models` for transforming and passing data to "views" (ie. Inertia components/pages)
    - `Actions` which are used to keep models and controllers "thin" and free of "business logic"
- The filamentphp/filament package is installed but should not be used outside of the "central" admin.APP_URL/* routes.
- The primary per-tenant app uses react-aria-components which are styled in accordance to the project's design system.