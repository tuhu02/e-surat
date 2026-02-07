<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $memintaSurat = Permission::firstOrCreate(['name' => 'meminta surat']);
        $membuatSurat = Permission::firstOrCreate(['name' => 'membuat surat']);
        $ttdSurat = Permission::firstOrCreate(['name' => 'ttd surat']);

        $mahasiswa = User::create([
            'name' => 'Mahasiswa',
            'email' => 'tuhuwkwk@gmail.com',
            'password' => bcrypt('tuhu.tuhu'),
        ]);

        $mahasiswa->assignRole('mahasiswa');
        $mahasiswa->givePermissionTo($memintaSurat);

        $dosen = User::create([
            'name' => 'Dosen',
            'email' => 'dosen@gmail.com',
            'password' => bcrypt('tuhu.tuhu'),
        ]);

        $dosen->assignRole('dosen');
        $dosen->givePermissionTo($memintaSurat);

    }
}
