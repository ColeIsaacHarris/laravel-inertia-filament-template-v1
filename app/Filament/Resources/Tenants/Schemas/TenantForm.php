<?php

namespace App\Filament\Resources\Tenants\Schemas;

use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Stancl\Tenancy\Database\Models\Domain;

class TenantForm
{
    public static function baseDomain(): string
    {
        return str(config('app.url'))->after('://')->before('/')->before(':')->toString();
    }

    public static function configure(Schema $schema): Schema
    {
        $baseDomain = static::baseDomain();

        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('domain')
                    ->label('Subdomain')
                    ->required()
                    ->alphaNum()
                    ->suffix('.'.$baseDomain)
                    ->rules([
                        fn (?string $operation, $record): Closure => function (string $attribute, $value, Closure $fail) use ($baseDomain, $operation, $record): void {
                            $fullDomain = $value.'.'.$baseDomain;

                            $query = Domain::where('domain', $fullDomain);

                            if ($operation === 'edit' && $record) {
                                $currentDomain = $record->domains()->first();

                                if ($currentDomain) {
                                    $query->where('id', '!=', $currentDomain->id);
                                }
                            }

                            if ($query->exists()) {
                                $fail('This subdomain is already taken.');
                            }
                        },
                    ])
                    ->dehydrateStateUsing(fn (string $state): string => $state.'.'.$baseDomain),
            ]);
    }
}
