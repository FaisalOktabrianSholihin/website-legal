<?php

namespace Database\Seeders;

use App\Models\StatusDokumen;
use Illuminate\Database\Seeder;

class StatusDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_status' => 'Aktif'],
            ['nama_status' => 'Akan Berakhir'],
            ['nama_status' => 'Kadaluarsa'],
        ];

        foreach ($data as $item) {
            StatusDokumen::updateOrCreate(
                ['nama_status' => $item['nama_status']],
                $item
            );
        }
    }
}
