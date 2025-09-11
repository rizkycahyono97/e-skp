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
        $rektorat = Unit::updateOrCreate(['unit_name' => 'Rektorat']);
        $fakultas = Unit::updateOrCreate(['unit_name' => 'Fakultas', 'parent_unit_id' => $rektorat->unit_id]);
        $prodi = Unit::updateOrCreate(['unit_name' => 'Prodi', 'parent_unit_id' => $fakultas->unit_id]);

        // position
        Position::updateOrCreate(['position_name' => 'Rektor']);
        Position::updateOrCreate(['position_name' => 'Dekan']);
        Position::updateOrCreate(['position_name' => 'Kaprodi']);
        Position::updateOrCreate(['position_name' => 'Dosen']);
        Position::updateOrCreate(['position_name' => 'Tendik']);
    }
}