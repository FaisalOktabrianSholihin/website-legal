<?php

namespace App\Filament\Resources\Dokumens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Carbon;


class DokumensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (request()->has('jenis')) {
                    $query->whereHas(
                        'jenis',
                        fn($q) =>
                        $q->where('slug', request('jenis'))
                    );
                }
            })
            ->columns([
                TextColumn::make('jenis.nama_jenis')
                    ->label('Jenis')
                    ->badge()
                    ->sortable(),

                TextColumn::make('no_dokumen')
                    ->label('No Dokumen')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_dokumen')
                    ->label('Nama Dokumen')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('tgl_awal')
                    ->label('Mulai')
                    ->date(),

                TextColumn::make('tgl_akhir')
                    ->label('Berakhir')
                    ->date()
                    ->sortable(),

                BadgeColumn::make('status.nama_status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Aktif',
                        'danger' => 'Tidak Aktif',
                        'warning' => 'Akan Berakhir',
                    ]),

                BadgeColumn::make('sisa_hari')
                    ->label('Sisa Hari')
                    ->getStateUsing(
                        fn($record) =>
                        $record->tgl_akhir
                            ? Carbon::now()->diffInDays($record->tgl_akhir, false)
                            : null
                    )
                    ->colors([
                        'danger' => fn($state) => $state <= 10,
                        'warning' => fn($state) => $state <= 30,
                        'success' => fn($state) => $state > 30,
                    ])
                    ->formatStateUsing(fn($state) => $state . ' hari'),
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
