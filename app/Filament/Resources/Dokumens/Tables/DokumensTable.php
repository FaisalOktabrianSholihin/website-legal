<?php

namespace App\Filament\Resources\Dokumens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Carbon;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;


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

                // BadgeColumn::make('sisa_hari')
                //     ->label('Sisa Hari')
                //     ->getStateUsing(
                //         fn($record) =>
                //         $record->tgl_akhir
                //             ? Carbon::now()->diffInDays($record->tgl_akhir, false)
                //             : null
                //     )
                //     ->colors([
                //         'danger' => fn($state) => $state <= 10,
                //         'warning' => fn($state) => $state <= 30,
                //         'success' => fn($state) => $state > 30,
                //     ])
                //     ->formatStateUsing(fn($state) => $state . ' hari'),
                // TextColumn::make('sisa_hari')
                //     ->label('Sisa Waktu')
                //     ->getStateUsing(function ($record) {
                //         if (!$record->tgl_akhir) return null;

                //         $now = Carbon::now();
                //         $target = Carbon::parse($record->tgl_akhir);

                //         // Jika sudah lewat (Expired)
                //         if ($now->greaterThan($target)) {
                //             return 'Expired';
                //         }

                //         $diffInMonths = $now->diffInMonths($target);
                //         $diffInDays = $now->diffInDays($target);
                //         $diffInHours = $now->diffInHours($target);

                //         // 1. Jika sisa waktu lebih dari atau sama dengan 1 bulan
                //         if ($diffInMonths >= 1) {
                //             return $diffInMonths . ' bulan';
                //         }

                //         // 2. Jika kurang dari 1 bulan tapi lebih dari 1 hari
                //         if ($diffInDays >= 1) {
                //             return $diffInDays . ' hari';
                //         }

                //         // 3. Jika kurang dari 1 hari (tampilkan jam)
                //         return $diffInHours . ' jam';
                //     })
                //     ->badge()
                //     ->colors([
                //         'success' => fn($state) => str_contains($state, 'bulan'),
                //         'warning' => fn($state) => str_contains($state, 'hari'),
                //         'danger' => fn($state) => str_contains($state, 'jam') || $state === 'Expired',
                //     ]),

                TextColumn::make('sisa_waktu')
                    ->label('Sisa Waktu')
                    ->getStateUsing(function ($record) {
                        if (!$record->tgl_akhir) return null;

                        $now = Carbon::now();
                        $target = Carbon::parse($record->tgl_akhir);

                        if ($now->greaterThan($target)) return 'Expired';

                        $diffInMonths = (int) $now->diffInMonths($target);
                        $diffInDays = (int) $now->diffInDays($target);
                        $diffInHours = (int) $now->diffInHours($target);

                        // Logika bertingkat
                        if ($diffInMonths >= 1) {
                            return $diffInMonths . ' bulan';
                        }

                        if ($diffInDays >= 1) {
                            return $diffInDays . ' hari';
                        }

                        return $diffInHours . ' jam';
                    })
                    ->badge()
                    ->colors([
                        'success' => fn($state) => str_contains($state, 'bulan'),
                        'warning' => fn($state) => str_contains($state, 'hari'),
                        'danger' => fn($state) => str_contains($state, 'jam') || $state === 'Expired',
                    ]),
            ])

            // ->filters([
            //     //
            // ])

            ->filters([
                // 1. Filter Cepat Berdasarkan Kategori Waktu
                Filter::make('status_expired')
                    ->label('Status Kadaluarsa')
                    ->form([
                        Select::make('expired_category')
                            ->label('Kategori Waktu')
                            ->options([
                                'sudah_lewat' => 'Sudah Lewat (Expired)',
                                'minggu_ini' => 'Berakhir Minggu Ini',
                                'bulan_ini' => 'Berakhir Bulan Ini',
                                'aman' => 'Masih Lama (> 1 Bulan)',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['expired_category'] === 'sudah_lewat',
                                fn(Builder $query) => $query->where('tgl_akhir', '<', now())
                            )
                            ->when(
                                $data['expired_category'] === 'minggu_ini',
                                fn(Builder $query) => $query->whereBetween('tgl_akhir', [now(), now()->addDays(7)])
                            )
                            ->when(
                                $data['expired_category'] === 'bulan_ini',
                                fn(Builder $query) => $query->whereBetween('tgl_akhir', [now(), now()->addDays(30)])
                            )
                            ->when(
                                $data['expired_category'] === 'aman',
                                fn(Builder $query) => $query->where('tgl_akhir', '>', now()->addDays(30))
                            );
                    }),

                // 2. Filter Range Tanggal Custom
                Filter::make('tgl_akhir_range')
                    ->label('Rentang Tanggal Berakhir')
                    ->form([
                        DatePicker::make('dari_tanggal')->label('Dari Tanggal'),
                        DatePicker::make('sampai_tanggal')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tgl_akhir', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tgl_akhir', '<=', $date),
                            );
                    })
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
