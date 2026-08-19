<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Seed a newly created tenant's database.
     *
     * Runs automatically via Stancl\Tenancy\Jobs\SeedDatabase whenever a tenant
     * is created (see TenancyServiceProvider), and via `php artisan tenants:seed`.
     *
     * Local-only on purpose: tests create their own fixtures, and seeding a
     * known-password user into every tenant would be a production footgun.
     */
    public function run(): void
    {
        if (! app()->environment('local')) {
            return;
        }

        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'email_verified_at' => now(),
            ],
        );
    }
}
