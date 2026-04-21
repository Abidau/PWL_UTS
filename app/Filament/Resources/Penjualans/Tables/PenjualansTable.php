<?php

namespace App\Filament\Resources\Penjualans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PenjualansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('penjualan_kode')
                    ->label('Kode Penjualan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('penjualan_tanggal')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('pembeli')
                    ->label('Pembeli')
                    ->searchable(),
                TextColumn::make('user.nama')
                    ->label('Petugas')
                    ->sortable(),
                TextColumn::make('total_harga')
                    ->label('Total Bayar')
                    ->money('IDR')
                    ->getStateUsing(fn ($record) => $record->details->sum(fn ($detail) => $detail->harga * $detail->jumlah)),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
