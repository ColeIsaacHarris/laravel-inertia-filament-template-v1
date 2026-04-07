<?php

use App\Filament\Widgets\TenantStatsOverview;
use App\Models\Admin;
use App\Models\Tenant;
use Livewire\Livewire;

test('it displays the tenant count', function () {
    $this->actingAs(Admin::factory()->create(), 'admin');

    Tenant::withoutEvents(function () {
        Tenant::create(['id' => 'tenant-1', 'name' => 'Tenant One']);
        Tenant::create(['id' => 'tenant-2', 'name' => 'Tenant Two']);
        Tenant::create(['id' => 'tenant-3', 'name' => 'Tenant Three']);
    });

    Livewire::test(TenantStatsOverview::class)
        ->assertSeeText('3')
        ->assertSeeText('Total active tenants');
});
