<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'k1',
                'kategori_nama' => 'Makanan',
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'k2',
                'kategori_nama' => 'Minuman',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'k3',
                'kategori_nama' => 'Sembako',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'k4',
                'kategori_nama' => 'Body Care',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'k5',
                'kategori_nama' => 'Alat Kebersihan',
            ],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
