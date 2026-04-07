<?php

namespace App\Filament\Resources\Tenants\Pages;

use App\Filament\Resources\Tenants\Schemas\TenantForm;
use App\Filament\Resources\Tenants\TenantResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $fullDomain = $this->record->domains()->first()?->domain;
        $data['domain'] = str($fullDomain)->before('.'.TenantForm::baseDomain())->toString();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $domain = $data['domain'];
        unset($data['domain']);

        $this->record->domains()->updateOrCreate(
            ['tenant_id' => $this->record->getTenantKey()],
            ['domain' => $domain],
        );

        return $data;
    }
}
