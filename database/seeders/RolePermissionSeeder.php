<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Role
        $mahasiswa = Role::firstOrCreate(['name' => 'mahasiswa']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $dosen = Role::firstOrCreate(['name' => 'dosen']);
        $superAdmin = Role::firstOrCreate(['name' => 'superAdmin']);

        // Create Permission
        $memintaSurat = Permission::firstOrCreate(['name' => 'meminta surat']);
        $membuatSurat = Permission::firstOrCreate(['name' => 'membuat surat']);
        $ttdSurat = Permission::firstOrCreate(['name' => 'ttd surat']);
        $manajemenUser = Permission::firstOrCreate(['name' => 'manajemen user']);
        $manajemenRole = Permission::firstOrCreate(['name' => 'manajemen role']);

        // Asign
        $mahasiswa->givePermissionTo($memintaSurat);
        $admin->givePermissionTo($membuatSurat);
        $superAdmin->givePermissionTo($manajemenUser);
        $superAdmin->givePermissionTo($manajemenRole);
        $dosen->givePermissionTo($ttdSurat);

    }
}
