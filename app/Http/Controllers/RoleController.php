<?php

// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles-permission.roles.index', compact('roles'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('roles-permission.roles.create',compact('permission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permission' => 'required',
        ]);
        // dd($request->input('permission'));
        try {
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error syncing permissions: ' . $e->getMessage()]);
        }

        return redirect()->route('roles-permission.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('roles-permission.roles.create', compact('role','permission','rolePermissions'));
    }

    public function update(Request $request, $id)
    {

        $role = Role::find($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permission' => 'required',
        ]);


        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles-permission.roles.index')->with('success', 'Role updated successfully.');
    }

     public function destroy(string $id)
    {
         DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}
