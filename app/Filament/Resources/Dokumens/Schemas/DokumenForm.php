<?php

namespace App\Filament\Resources\Dokumens\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DokumenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jenis_dokumen_id')
                    ->label('Jenis Dokumen')
                    ->relationship('jenis', 'nama_jenis')
                    ->required(),

                TextInput::make('nomor_dokumen')
                    ->required(),

                TextInput::make('nama_dokumen')
                    ->required(),

                DatePicker::make('tgl_mulai')
                    ->required(),

                DatePicker::make('tgl_akhir')
                    ->required(),

                Select::make('status_dokumen_id')
                    ->label('Status Dokumen')
                    ->relationship('status', 'nama_status')
                    ->required(),

                TextInput::make('nama_dokumen')
                    ->required(),

                Textarea::make('catatan')
                    ->columnSpanFull(),

                FileUpload::make('file_dokumen')
                    ->label('Lampiran Dokumen (PDF)')
                    ->directory('dokumen')
                    ->acceptedFileTypes(['application/pdf'])
                    ->preserveFilenames()
                    ->columnSpanFull(),
            ])
            ->columns(2); // Menambahkan ini agar input berjejer 2 kolom dan memenuhi ruang kanan
    }
}
