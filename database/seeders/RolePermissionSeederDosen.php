<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeederDosen extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosen = Role::where('name', 'dosen')->first();
        $permission = Permission::firstOrCreate(['name' => 'view.dosen.dashboard']);

        $dosen->givePermissionTo($permission);
    }
}
