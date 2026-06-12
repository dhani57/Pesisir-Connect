<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama')
                    ->description('Detail nama dan peran pengguna')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        Select::make('role')
                            ->options(['admin' => 'Admin', 'vendor' => 'Vendor', 'customer' => 'Customer'])
                            ->default('customer')
                            ->in(['admin', 'vendor', 'customer'])
                            ->required(),
                        TextInput::make('password')
                            ->password()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                    ])->columns(['sm' => 1, 'md' => 2]),

                Section::make('Data Tambahan')
                    ->description('Informasi opsional pengguna')
                    ->schema([
                        TextInput::make('phone')
                            ->tel(),
                        TextInput::make('avatar'),
                        Textarea::make('address')
                            ->columnSpanFull(),
                    ])->columns(['sm' => 1, 'md' => 2]),

                Section::make('Status & Verifikasi')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Akun Aktif / Disetujui')
                            ->required(),
                        DateTimePicker::make('email_verified_at'),
                    ])->columns(['sm' => 1, 'md' => 2]),
            ]);
    }
}
