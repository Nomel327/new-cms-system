<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use illuminate\Support\Str;

class PermissionController extends Controller
{
    //

    public function index(){
        return view('admin.permissions.index', [
            'permissions' => Permission::all()
        ]);
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', [
            'permission' => $permission,
            'roles' => Role::all()
        ]);
    }

    public function store()
    {

        request()->validate([
            'name' => ['required']
        ]);

        Permission::create([
            'name' => Str::ucfirst(request('name')),
            'slug' => Str::of(Str::lower(request('name')))->slug('-')
        ]);

        return back();
    }

    public function update(Permission $permission)
    {
        $permission->name = Str::ucfirst(request('name'));
        $permission->slug = Str::of(request('name'))->slug('-');

        if ($permission->isDirty('name')) {
            session()->flash('permission-updated', 'Permission Update: ' . request('name'));
            $permission->save();
        } else {
            session()->flash('permission-updated', 'Nothing has been updated');
        }

        return back();
    }

    public function attach_permission(Permission $permission)
    {

        $permission->roles()->attach(request('roles'));

        return back();
    }

    public function detach_permission(Permission $permission)
    {

        $permission->roles()->detach(request('roles'));

        return back();
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        session()->flash('permission-deleted', 'Deleted Permission' . $permission->name);

        return back();
    }
}
