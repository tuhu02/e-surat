<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();

        return view('admin.roles.index', compact('role'));
    }

    public function create(){
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $user = Role::firstOrCreate([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil dihapus');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,'.$id,
        ]);

        $role = Role::fidOrFail($id);

        $role->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil diperbarui');
    }
}
