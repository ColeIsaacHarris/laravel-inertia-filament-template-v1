<?php

namespace Tests\Concerns;

use App\Models\Tenant;
use Stancl\Tenancy\Bootstrappers\CacheTenancyBootstrapper;

trait WithTenancy
{
    public Tenant $tenant;

    protected function setUpWithTenancy(): void
    {
        // The CacheTenancyBootstrapper does not support the array cache driver
        // used in testing, so remove it from the bootstrapper list.
        config(['tenancy.bootstrappers' => array_values(array_filter(
            config('tenancy.bootstrappers'),
            fn (string $b) => $b !== CacheTenancyBootstrapper::class,
        ))]);

        // Migrate the central database fresh. This also drops any leftover
        // tenant databases thanks to drop_tenant_databases_on_migrate_fresh.
        $this->artisan('migrate:fresh', [
            '--database' => config('tenancy.database.central_connection'),
            '--force' => true,
        ]);

        // Create the tenant — events fire the CreateDatabase and MigrateDatabase
        // jobs, so the tenant database is ready when this returns.
        $this->tenant = Tenant::create([
            'id' => 'test',
            'name' => 'Test Tenant',
        ]);

        // Register a domain so the domain-identification middleware can resolve
        // the tenant from HTTP requests made during tests.
        $this->tenant->domains()->create(['domain' => 'test.localhost']);

        tenancy()->initialize($this->tenant);

        // Point the app URL at the tenant domain so route() helpers and test
        // HTTP requests target the correct host.
        config(['app.url' => 'http://test.localhost']);
        url()->forceRootUrl('http://test.localhost');
    }

    protected function tearDownWithTenancy(): void
    {
        tenancy()->end();

        // Purge the tenant connection so PostgreSQL releases all sessions,
        // allowing migrate:fresh to drop the tenant database in the next test.
        app('db')->purge('tenant');
    }
}
