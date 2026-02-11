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
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);

        // Create Permission
        $createPengajuan = Permission::firstOrCreate(['name' => 'create.pengajuan']);

        // permission admin
        $readPengajuan = Permission::firstOrCreate(['name' => 'read.pengajuan']);
        $approvePengajuan = Permission::firstOrCreate(['name' => 'approve.pengajuan']);
        $rejectPengajuan = Permission::firstOrCreate(['name' => 'reject.pengajuan']);

        // permission super admin
        $createUser = Permission::firstOrCreate(['name' => 'create.user']);
        $readUser = Permission::firstOrCreate(['name' => 'read.user']);
        $updateUser = Permission::firstOrCreate(['name' => 'update.user']);
        $deleteUser = Permission::firstOrCreate(['name' => 'delete.user']);

        $createRole = Permission::firstOrCreate(['name' => 'create.role']);
        $readRole = Permission::firstOrCreate(['name' => 'read.role']);
        $updateRole = Permission::firstOrCreate(['name' => 'update.role']);
        $deleteRole = Permission::firstOrCreate(['name' => 'delete.role']);


        // give permission
        $mahasiswa->givePermissionTo($createPengajuan);
        
        $admin->givePermissionTo([
            $readPengajuan,
            $approvePengajuan,
            $rejectPengajuan,
        ]);

        $superAdmin->givePermissionTo([
            $createUser,
            $readUser,
            $updateUser,
            $deleteUser,
            $createRole,
            $readRole,
            $updateRole,
            $deleteRole,
        ]);

    }
}
