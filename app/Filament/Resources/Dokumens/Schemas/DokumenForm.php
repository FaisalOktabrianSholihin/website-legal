<?php

namespace App\Filament\Resources\Dokumens\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;

class DokumenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jenis_id')
                    ->label('Jenis Dokumen')
                    ->relationship('jenis', 'nama_jenis')
                    ->required(),

                Select::make('status_id')
                    ->label('Status Dokumen')
                    ->relationship('status', 'nama_status')
                    ->required(),

                TextInput::make('no_dokumen')
                    ->required(),

                TextInput::make('nama_dokumen')
                    ->required(),

                DatePicker::make('tgl_awal')
                    ->required(),

                DatePicker::make('tgl_akhir')
                    ->required(),

                TextInput::make('lokasi')
                    ->required(),

                Textarea::make('catatan')
                    ->required(),
                // ->columnSpanFull(),

                Section::make('Daftar Para Pihak')
                    ->description('Masukkan daftar pihak yang terlibat dalam dokumen ini.')
                    ->schema([
                        Repeater::make('pihak') // Nama relasi di Model Dokumen
                            ->relationship('pihak')
                            ->schema([
                                TextInput::make('nama_pihak')
                                    ->label('Nama Pihak')
                                    ->placeholder('Contoh: PT. Maju Jaya / Ahmad')
                                    ->required(),
                                TextInput::make('jabatan_pihak')
                                    ->label('Jabatan')
                                    ->placeholder('Contoh: Direktur / Manager')
                                    ->required(),
                            ])
                            ->columns(2) // Agar input Nama & Jabatan berjejer
                            ->defaultItems(1) // Muncul 1 baris kosong saat pertama buka
                            ->reorderableWithButtons() // Bisa diatur urutannya
                            ->addActionLabel('Tambah Pihak Baru') // Label tombol plus
                            // ->itemLabel(function (array $state, $uuid, $component) {
                            //     $items = $component->getContainer()->getRawState();
                            //     if (is_array($items)) {
                            //         $index = array_search($uuid, array_keys($items));
                            //         return 'Pihak ke-' . ($index + 1);
                            //     }
                            //     return 'Pihak';
                            // }),
                            ->itemLabel(function (array $state, string $uuid, Repeater $component) {
                                $items = array_values($component->getState() ?? []);
                                $current = array_search($state, $items, true);
                                $number = $current !== false ? $current + 1 : 1;

                                $nama = $state['nama_pihak'] ?? '...';

                                return "Pihak ke-{$number}: {$nama}";
                            })

                    ]),
                // ->columnSpanFull(),

                FileUpload::make('attachment')
                    ->label('Lampiran Dokumen (PDF)')
                    ->directory('dokumen')
                    ->acceptedFileTypes(['application/pdf'])
                    ->preserveFilenames(),
                // ->columnSpanFull(),
            ])
            ->columns(2); // Menambahkan ini agar input berjejer 2 kolom dan memenuhi ruang kanan
    }
}
