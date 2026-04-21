<?php

namespace App\Filament\Resources\Penjualans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use App\Models\Barang;

class PenjualanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Penjualan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('penjualan_kode')
                                    ->label('Kode Penjualan')
                                    ->required()
                                    ->maxLength(20),
                                DateTimePicker::make('penjualan_tanggal')
                                    ->label('Tanggal Penjualan')
                                    ->required()
                                    ->default(now()),
                                TextInput::make('pembeli')
                                    ->label('Nama Pembeli')
                                    ->required()
                                    ->maxLength(100),
                                Select::make('user_id')
                                    ->label('Petugas (User)')
                                    ->relationship('user', 'nama')
                                    ->required(),
                            ]),
                    ]),
                Section::make('Item Penjualan')
                    ->schema([
                        Repeater::make('details')
                            ->label('Daftar Barang')
                            ->relationship('details')
                            ->schema([
                                Select::make('barang_id')
                                    ->label('Barang')
                                    ->relationship('barang', 'barang_nama')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('harga', Barang::find($state)?->harga_jual ?? 0)),
                                TextInput::make('harga')
                                    ->label('Harga Satuan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                                TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->required()
                                    ->default(1),
                            ])
                            ->columns(3)
                            ->minItems(1),
                    ]),
            ]);
    }
}
