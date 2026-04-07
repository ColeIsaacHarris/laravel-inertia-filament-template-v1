<?php

namespace Tests\Concerns;

use App\Models\Tenant;
use Stancl\Tenancy\Bootstrappers\CacheTenancyBootstrapper;

trait WithSharedTenancy
{
    protected static bool $tenantCreated = false;

    public Tenant $tenant;

    protected function setUpWithSharedTenancy(): void
    {
        config(['tenancy.bootstrappers' => array_values(array_filter(
            config('tenancy.bootstrappers'),
            fn (string $b) => $b !== CacheTenancyBootstrapper::class,
        ))]);

        if (! static::$tenantCreated) {
            $this->artisan('migrate:fresh', [
                '--database' => config('tenancy.database.central_connection'),
                '--force' => true,
            ]);

            $tenant = Tenant::create([
                'id' => 'test',
                'name' => 'Test Tenant',
            ]);

            $tenant->domains()->create(['domain' => 'test.localhost']);

            static::$tenantCreated = true;
        }

        $this->tenant = Tenant::find('test');

        tenancy()->initialize($this->tenant);

        // Wrap each test in a transaction for isolation without rebuilding the DB.
        app('db')->connection('tenant')->beginTransaction();
    }

    protected function tearDownWithSharedTenancy(): void
    {
        app('db')->connection('tenant')->rollBack();

        tenancy()->end();

        app('db')->purge('tenant');
    }
}
