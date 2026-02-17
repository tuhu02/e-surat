<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeederMahasiswa extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswa = Role::where('name', 'mahasiswa')->first();
        
        $createPengajuanTtd = Permission::firstOrCreate(['name' => 'create.pengajuan.ttd']);
        $readPengajuanTtd = Permission::firstOrCreate(['name' => 'read.pengajuan.ttd']);

        $mahasiswa->givePermissionTo([
            $readPengajuanTtd,
            $createPengajuanTtd,
        ]);
    }
}
