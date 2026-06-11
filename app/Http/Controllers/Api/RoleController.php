<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreRoleRequest;
use App\Http\Requests\Api\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $roles = Role::with('permissions')->get();

        return $this->successResponse(RoleResource::collection($roles));
    }

    public function show(int $id): JsonResponse
    {
        $role = Role::with('permissions')->findOrFail($id);

        return $this->successResponse(new RoleResource($role));
    }

    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = Role::create(['name' => $request->name]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        $role->load('permissions');

        return $this->successResponse(
            new RoleResource($role),
            'Role berhasil ditambahkan.',
            201
        );
    }

    public function update(UpdateRoleRequest $request, int $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions ?? []);
        }

        $role->load('permissions');

        return $this->successResponse(new RoleResource($role), 'Role berhasil diperbarui.');
    }

    public function destroy(int $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return $this->successResponse(null, 'Role berhasil dihapus.');
    }

    public function permissions(): JsonResponse
    {
        $permissions = Permission::all(['id', 'name']);

        return $this->successResponse($permissions);
    }
}
