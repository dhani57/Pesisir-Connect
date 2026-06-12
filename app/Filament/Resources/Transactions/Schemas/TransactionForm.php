<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama')
                    ->description('Detail invoice dan produk')
                    ->schema([
                        TextInput::make('invoice_number')
                            ->required(),
                        Select::make('user_id')
                            ->relationship('customer', 'name')
                            ->label('Customer')
                            ->searchable()
                            ->required(),
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'confirmed' => 'Confirmed',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                                'refunded' => 'Refunded',
                            ])
                            ->default('pending')
                            ->required(),
                    ])->columns(['sm' => 1, 'md' => 2]),

                Section::make('Detail Booking')
                    ->description('Tanggal dan jumlah tamu')
                    ->schema([
                        DatePicker::make('check_in')
                            ->required(),
                        DatePicker::make('check_out')
                            ->required(),
                        TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->default(1),
                        TextInput::make('guests')
                            ->required()
                            ->numeric()
                            ->default(1),
                    ])->columns(['sm' => 1, 'md' => 2, 'lg' => 4]),

                Section::make('Harga & Pembayaran')
                    ->schema([
                        TextInput::make('unit_price')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        TextInput::make('total_price')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Select::make('payment_method')
                            ->options(['midtrans' => 'Midtrans', 'bank_transfer' => 'Bank transfer', 'cash' => 'Cash'])
                            ->default('midtrans')
                            ->required(),
                        DateTimePicker::make('paid_at'),
                    ])->columns(['sm' => 1, 'md' => 2]),

                Section::make('Data Gateway Midtrans')
                    ->schema([
                        TextInput::make('midtrans_transaction_id'),
                        TextInput::make('midtrans_payment_type'),
                        TextInput::make('midtrans_response'),
                    ])->columns(['sm' => 1, 'md' => 3])
                    ->collapsed(),

                Section::make('Catatan Tambahan')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Catatan Pelanggan'),
                        Textarea::make('vendor_notes')
                            ->label('Catatan Vendor'),
                    ])->columns(['sm' => 1, 'md' => 2]),
            ]);
    }
}
