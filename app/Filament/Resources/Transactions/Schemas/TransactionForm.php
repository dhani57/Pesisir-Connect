<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
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
                TextInput::make('unit_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
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
                Select::make('payment_method')
                    ->options(['midtrans' => 'Midtrans', 'bank_transfer' => 'Bank transfer', 'cash' => 'Cash'])
                    ->default('midtrans')
                    ->required(),
                TextInput::make('midtrans_transaction_id'),
                TextInput::make('midtrans_payment_type'),
                TextInput::make('midtrans_response'),
                DateTimePicker::make('paid_at'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Textarea::make('vendor_notes')
                    ->columnSpanFull(),
            ]);
    }
}
