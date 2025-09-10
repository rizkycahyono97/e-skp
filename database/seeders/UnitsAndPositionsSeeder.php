<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitsAndPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Unit
        $rektorat = Unit::firstOrCreate(['unit_name' => 'Rektorat']);
        $fakultas = Unit::firstOrCreate(['unit_name' => 'Fakultas', 'parent_unit_id' => $rektorat->unit_id]);
        $prodi = Unit::firstOrCreate(['unit_name' => 'Prodi', 'parent_unit_id' => $fakultas->unit_id]);

        // position
        Position::firstOrCreate(['position_name' => 'Rektor']);
        Position::firstOrCreate(['position_name' => 'Dekan']);
        Position::firstOrCreate(['position_name' => 'Kaprodi']);
        Position::firstOrCreate(['position_name' => 'Dosen']);
        Position::firstOrCreate(['position_name' => 'Tendik']);
    }
}