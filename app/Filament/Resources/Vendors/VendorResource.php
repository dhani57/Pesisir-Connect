<?php

namespace App\Filament\Resources\Vendors;

use App\Filament\Resources\Vendors\Pages\CreateVendor;
use App\Filament\Resources\Vendors\Pages\EditVendor;
use App\Filament\Resources\Vendors\Pages\ListVendors;
use App\Models\Vendor;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;
    protected static ?string $recordTitleAttribute = 'shop_name';
    protected static ?string $navigationLabel = 'Vendor';
    protected static ?string $modelLabel = 'Vendor';
    protected static ?string $pluralModelLabel = 'Vendor';
    protected static \UnitEnum|string|null $navigationGroup = 'Manajemen Vendor';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Toko')
                ->description('Data toko dan status vendor.')
                ->icon('heroicon-o-building-storefront')
                ->schema([
                    TextInput::make('shop_name')
                        ->label('Nama Toko')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('phone')
                        ->label('Telepon')
                        ->maxLength(20),
                    TextInput::make('business_type')
                        ->label('Jenis Usaha')
                        ->maxLength(100),
                    Textarea::make('bio')
                        ->label('Deskripsi')
                        ->rows(3)
                        ->columnSpanFull(),
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'pending_approval' => 'Menunggu Persetujuan',
                            'approved'         => 'Disetujui',
                            'suspended'        => 'Ditangguhkan',
                            'deactivated'      => 'Nonaktif',
                        ])
                        ->required(),
                    Toggle::make('is_approved')
                        ->label('Disetujui'),
                ])
                ->columns(2),

            Section::make('Alamat')
                ->icon('heroicon-o-map-pin')
                ->schema([
                    Textarea::make('address')
                        ->label('Alamat')
                        ->rows(2)
                        ->columnSpanFull(),
                    TextInput::make('city')
                        ->label('Kota')
                        ->maxLength(100),
                    TextInput::make('zip_code')
                        ->label('Kode Pos')
                        ->maxLength(10),
                ])
                ->columns(2),

            Section::make('Rekening Bank')
                ->icon('heroicon-o-banknotes')
                ->schema([
                    TextInput::make('bank_name')
                        ->label('Bank')
                        ->maxLength(100),
                    TextInput::make('account_holder')
                        ->label('Atas Nama')
                        ->maxLength(255),
                    TextInput::make('account_number')
                        ->label('No. Rekening')
                        ->maxLength(50),
                ])
                ->columns(3),

            Section::make('Komisi & Pendapatan')
                ->icon('heroicon-o-currency-dollar')
                ->schema([
                    TextInput::make('commission_rate')
                        ->label('Tarif Komisi (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->step(0.01)
                        ->suffix('%'),
                    TextInput::make('total_earnings')
                        ->label('Total Pendapatan')
                        ->numeric()
                        ->prefix('Rp')
                        ->disabled(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shop_name')
                    ->label('Nama Toko')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Pemilik')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'approved'         => 'Disetujui',
                        'pending_approval' => 'Menunggu',
                        'suspended'        => 'Ditangguhkan',
                        'deactivated'      => 'Nonaktif',
                        default            => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'approved'         => 'success',
                        'pending_approval' => 'warning',
                        'suspended'        => 'danger',
                        'deactivated'      => 'gray',
                        default            => 'gray',
                    }),
                TextColumn::make('commission_rate')
                    ->label('Komisi')
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('total_earnings')
                    ->label('Pendapatan')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('products_count')
                    ->label('Produk')
                    ->counts('products')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Bergabung')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending_approval' => 'Menunggu',
                        'approved'         => 'Disetujui',
                        'suspended'        => 'Ditangguhkan',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->color('success')
                    ->icon(Heroicon::OutlinedCheck)
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending_approval')
                    ->action(function ($record) {
                        app(\App\Services\VendorService::class)->approveVendor($record);
                    }),
                \Filament\Actions\Action::make('suspend')
                    ->label('Tangguhkan')
                    ->color('danger')
                    ->icon(Heroicon::OutlinedNoSymbol)
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'approved')
                    ->action(function ($record) {
                        app(\App\Services\VendorService::class)->suspendVendor($record);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListVendors::route('/'),
            'create' => CreateVendor::route('/create'),
            'edit'   => EditVendor::route('/{record}/edit'),
        ];
    }
}
