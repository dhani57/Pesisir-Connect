<?php

namespace App\Filament\Resources\Destinations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DestinationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Destinasi')
                    ->description('Detail mengenai destinasi wisata pesisir Lampung.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Tempat')
                            ->required()
                            ->maxLength(255),
                            
                        TextInput::make('location')
                            ->label('Lokasi (Krui/Pahawang, dll)')
                            ->required()
                            ->maxLength(255),

                        FileUpload::make('image')
                            ->label('Gambar Hero/Cover')
                            ->image()
                            ->directory('destinations')
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columns(['sm' => 1, 'md' => 2]),
            ]);
    }
}
