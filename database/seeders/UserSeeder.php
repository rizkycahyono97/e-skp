<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //memanggil class seeder spatie
        $this->call(RolesAndPermissionsSeeder::class);

        $rektoratUnit = Unit::where('unit_name', 'Rektorat')->first();
        $fakultasUnit = Unit::where('unit_name', 'Fakultas')->first();
        $prodiUnit = Unit::where('unit_name', 'Prodi')->first();
        $rektorPosition = Position::where('position_name', 'Rektor')->first();
        $dekanPosition = Position::where('position_name', 'Dekan')->first();
        $kaprodiPosition = Position::where('position_name', 'Kaprodi')->first();
        $dosenPosition = Position::where('position_name', 'Dosen')->first();

        // user dummy
        $userRektor = User::firstOrCreate(['nip' => '1001'], [
            'username' => 'Prof Dr. Rektor',
            'email' => 'rektor@unida.ac.id',
            'password' => Hash::make('test123'),
            'unit_id' => $rektoratUnit->unit_id,
            'position_id' => $rektorPosition->position_id,
        ]);
        $userRektor->assignRole('Rektor');

        $userDekan = User::firstOrCreate(['nip' => '1002'], [
            'username' => 'Dr. Dekan',
            'email' => 'dekan@unida.ac.id',
            'password' => Hash::make('test123'),
            'unit_id' => $fakultasUnit->unit_id,
            'position_id' => $dekanPosition->position_id,
        ]);
        $userDekan->assignRole('Dekan');

        $userKaprodi = User::firstOrCreate(['nip' => '1003'], [
            'username' => 'Dr. Kaprodi',
            'email' => 'kaprodi@unida.ac.id',
            'password' => Hash::make('test123'),
            'unit_id' => $prodiUnit->unit_id,
            'position_id' => $kaprodiPosition->position_id,
        ]);
        $userKaprodi->assignRole('Kaprodi');

        $userDosen = User::firstOrCreate(['nip' => '1004'], [
            'username' => 'Dr. Dosen',
            'email' => 'dosen@unida.ac.id',
            'password' => Hash::make('test123'),
            'unit_id' => $prodiUnit->unit_id,
            'position_id' => $dosenPosition->position_id,
        ]);
        $userDosen->assignRole('Dosen');
    }
}