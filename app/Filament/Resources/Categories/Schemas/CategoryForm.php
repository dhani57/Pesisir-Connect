<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->description('Data utama kategori layanan wisata.')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, ?string $state) =>
                                $set('slug', Str::slug($state ?? ''))
                            ),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Otomatis terisi dari nama. Bisa diubah manual.'),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(['sm' => 1, 'md' => 2]),

                Section::make('Media & Tampilan')
                    ->description('Ikon dan gambar untuk tampilan frontend.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        TextInput::make('icon')
                            ->label('Ikon (SVG/Class)')
                            ->helperText('Path ikon atau class name. Opsional.')
                            ->maxLength(255),

                        FileUpload::make('image')
                            ->label('Gambar Kategori')
                            ->image()
                            ->directory('categories')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450'),
                    ])
                    ->columns(['sm' => 1, 'md' => 2]),

                Section::make('Pengaturan')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka kecil ditampilkan lebih dulu.'),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Kategori nonaktif tidak tampil di frontend.'),
                    ])
                    ->columns(['sm' => 1, 'md' => 2]),
            ]);
    }
}
