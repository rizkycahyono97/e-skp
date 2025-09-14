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

        $superAdminUnit = Unit::where('unit_name', 'Super Admin')->first();
        $rektoratUnit = Unit::where('unit_name', 'Rektorat')->first();
        $fakultasUnit = Unit::where('unit_name', 'Fakultas')->first();
        $prodiUnit = Unit::where('unit_name', 'Prodi')->first();

        $superAdminPosition = Position::where('position_name', 'Super Admin')->first();
        $rektorPosition = Position::where('position_name', 'Rektor')->first();
        $dekanPosition = Position::where('position_name', 'Dekan')->first();
        $kaprodiPosition = Position::where('position_name', 'Kaprodi')->first();
        $dosenPosition = Position::where('position_name', 'Dosen')->first();

        // user dummy
        $superAdmin = User::firstOrCreate(['nip' => '0000'], [
            'name' => 'Super Admin',
            'username' => 'Super Admin',
            'email' => 'superadmin@unida.ac.id',
            'password' => Hash::make('test123'),
            'unit_id' => $superAdminUnit->id,
            'position_id' => $superAdminPosition->id,
        ]);
        $superAdmin->assignRole('Super Admin');

        $userRektor = User::firstOrCreate(['nip' => '1001'], [
            'name' => 'Rektor',
            'username' => 'Prof Dr. Rektor',
            'email' => 'rektor@unida.ac.id',
            'password' => Hash::make('test123'),
            'unit_id' => $rektoratUnit->id,
            'position_id' => $rektorPosition->id,
        ]);
        $userRektor->assignRole('Rektor');

        $userDekan = User::firstOrCreate(['nip' => '1002'], [
            'name' => 'Dekan',
            'username' => 'Dr. Dekan',
            'email' => 'dekan@unida.ac.id',
            'password' => Hash::make('test123'),
            'unit_id' => $fakultasUnit->id,
            'position_id' => $dekanPosition->id,
        ]);
        $userDekan->assignRole('Dekan');

        $userKaprodi = User::firstOrCreate(['nip' => '1003'], [
            'name' => 'Kaprodi',
            'username' => 'Dr. Kaprodi',
            'email' => 'kaprodi@unida.ac.id',
            'password' => Hash::make('test123'),
            'unit_id' => $prodiUnit->id,
            'position_id' => $kaprodiPosition->id,
        ]);
        $userKaprodi->assignRole('Kaprodi');

        $userDosen = User::firstOrCreate(['nip' => '1004'], [
            'name' => 'Dosen',
            'username' => 'Dr. Dosen',
            'email' => 'dosen@unida.ac.id',
            'password' => Hash::make('test123'),
            'unit_id' => $prodiUnit->id,
            'position_id' => $dosenPosition->id,
        ]);
        $userDosen->assignRole('Dosen');
    }
}