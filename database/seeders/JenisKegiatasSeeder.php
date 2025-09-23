<?php

namespace Database\Seeders;

use App\Models\JenisKegiatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisKegiatasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenis = [
            'Keilmuan',
            'Kerohanian',
            'Kesenian dan Keolahragaan',
            'Kemasyarakatan'
        ];

        foreach ($jenis as $j) {
            JenisKegiatan::updateOrCreate(
                ['nama' => $j],
                ['nama' => $j]
            );
        }
    }
}
