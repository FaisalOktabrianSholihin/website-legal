<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisDokumen;

class JenisDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_jenis' => 'Legal',
                'slug' => 'legal',
                'keterangan' => 'Dokumen perizinan dan legalitas',
            ],
            [
                'nama_jenis' => 'Kontrak',
                'slug' => 'kontrak',
                'keterangan' => 'Dokumen perjanjian dan kontrak kerja sama',
            ],
            [
                'nama_jenis' => 'Risalah',
                'slug' => 'risalah',
                'keterangan' => 'Dokumen risalah rapat dan notulensi',
            ],
        ];

        foreach ($data as $item) {
            JenisDokumen::updateOrCreate(
                ['slug' => $item['slug']], // kunci unik
                $item
            );
        }
    }
}
