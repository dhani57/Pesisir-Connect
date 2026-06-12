<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ─── Informasi Utama ───
                Section::make('Informasi Produk')
                    ->description('Data utama produk atau layanan wisata.')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, ?string $state) =>
                                $set('slug', Str::slug($state ?? '') . '-' . Str::random(5))
                            ),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Kategori')
                                    ->required(),
                            ]),

                        Select::make('user_id')
                            ->label('Vendor / Pemilik')
                            ->relationship('vendor', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Textarea::make('description')
                            ->label('Deskripsi Lengkap')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->rows(2)
                            ->maxLength(300)
                            ->helperText('Tampil di kartu produk. Maks 300 karakter.')
                            ->columnSpanFull(),
                    ])
                    ->columns(['sm' => 1, 'md' => 2]),

                // ─── Harga & Lokasi ───
                Section::make('Harga & Lokasi')
                    ->description('Informasi tarif dan lokasi layanan.')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga (Rp)')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0),

                        Select::make('price_unit')
                            ->label('Satuan Harga')
                            ->options([
                                'trip'   => 'Per Trip',
                                'jam'    => 'Per Jam',
                                'malam'  => 'Per Malam',
                                'set'    => 'Per Set',
                                'orang'  => 'Per Orang',
                            ])
                            ->default('malam')
                            ->required(),

                        Select::make('location')
                            ->label('Lokasi Destinasi')
                            ->options([
                                'Pahawang'      => 'Pulau Pahawang',
                                'Krui'          => 'Pantai Krui',
                                'Teluk Kiluan'  => 'Teluk Kiluan',
                            ])
                            ->required()
                            ->searchable(),

                        TextInput::make('address')
                            ->label('Alamat Lengkap')
                            ->maxLength(500),

                        TextInput::make('capacity')
                            ->label('Kapasitas')
                            ->numeric()
                            ->minValue(1)
                            ->suffix('orang')
                            ->helperText('Jumlah penumpang / tamu maksimal.'),

                        TextInput::make('whatsapp')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->prefix('+62')
                            ->placeholder('08xxxxxxxxxx')
                            ->helperText('Untuk tombol "Pesan via WhatsApp".'),
                    ])
                    ->columns(['sm' => 1, 'md' => 2, 'lg' => 3]),

                // ─── Media ───
                Section::make('Media')
                    ->description('Gambar utama dan galeri produk.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->label('Gambar Utama (Thumbnail)')
                            ->image()
                            ->directory('products/thumbnails')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('4:3')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('600')
                            ->columnSpanFull(),

                        FileUpload::make('gallery')
                            ->label('Galeri Foto')
                            ->image()
                            ->multiple()
                            ->directory('products/gallery')
                            ->reorderable()
                            ->maxFiles(6)
                            ->columnSpanFull(),
                    ]),

                // ─── Fasilitas ───
                Section::make('Fasilitas')
                    ->description('Daftar fasilitas yang tersedia.')
                    ->icon('heroicon-o-sparkles')
                    ->schema([
                        TagsInput::make('facilities')
                            ->label('Fasilitas')
                            ->placeholder('Ketik lalu tekan Enter...')
                            ->suggestions([
                                'WiFi', 'AC', 'Kamar Mandi Dalam', 'Parkir',
                                'Sarapan', 'Life Jacket', 'Guide', 'P3K',
                                'Dapur Bersama', 'Laundry', 'TV', 'Air Mineral',
                                'Masker', 'Snorkel', 'Fin', 'Kamera Underwater',
                            ])
                            ->columnSpanFull(),
                    ]),

                // ─── Pengaturan ───
                Section::make('Pengaturan')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        TextInput::make('rating')
                            ->label('Rating')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(5)
                            ->step(0.1),

                        TextInput::make('total_reviews')
                            ->label('Total Review')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_featured')
                            ->label('Produk Unggulan')
                            ->helperText('Tampilkan di halaman beranda.'),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Produk nonaktif tidak tampil di frontend.'),
                    ])
                    ->columns(['sm' => 1, 'md' => 2, 'lg' => 3]),
            ]);
    }
}
