<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the central database.
     *
     * Tenant databases are seeded by TenantDatabaseSeeder, which runs via the
     * Stancl\Tenancy\Jobs\SeedDatabase job in TenancyServiceProvider.
     */
    public function run(): void
    {
        Admin::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => 'password',
            ],
        );
    }
}
