<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 3,
                'pembeli' => 'Dea',
                'penjualan_kode' => 'p1',
                'penjualan_tanggal' => "2024-03-09 14:19:00.",
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 3,
                'pembeli' => 'Ratna',
                'penjualan_kode' => 'p2',
                'penjualan_tanggal' => "2024-03-09 14:19:00.",
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli' => 'Elva',
                'penjualan_kode' => 'p3',
                'penjualan_tanggal' => "2024-03-09 14:19:00.",
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 3,
                'pembeli' => 'Ana',
                'penjualan_kode' => 'p4',
                'penjualan_tanggal' => "2024-03-09 14:19:00.",
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 3,
                'pembeli' => 'Jihan',
                'penjualan_kode' => 'p5',
                'penjualan_tanggal' => "2024-03-09 14:19:00.",
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Fanes',
                'penjualan_kode' => 'p6',
                'penjualan_tanggal' => "2024-03-09 14:19:00.",
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 3,
                'pembeli' => 'Putri',
                'penjualan_kode' => 'p7',
                'penjualan_tanggal' => "2024-03-09 14:19:00.",
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 3,
                'pembeli' => 'Nadila',
                'penjualan_kode' => 'p8',
                'penjualan_tanggal' => "2024-03-09 14:19:00.",
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'Octa',
                'penjualan_kode' => 'p9',
                'penjualan_tanggal' => "2024-03-09 14:19:00.",
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3,
                'pembeli' => 'Maulita',
                'penjualan_kode' => 'p10',
                'penjualan_tanggal' => "2024-03-09 14:19:00.",
            ],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
