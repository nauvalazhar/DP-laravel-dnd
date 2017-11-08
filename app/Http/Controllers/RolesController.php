<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use DB;
use Session;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(config('starter.pagination'));
        $no = 1;
        return view('roles.index', compact('roles', 'no'));
    }

    public function create()
    {
        $permission = Permission::get();
        $perms = [];
        $i = 0;
        foreach($permission as $perm) {
            $exp = explode("_", $perm->name);

            $perms[$exp[0]][$i] = $perm;

            $i++;
        }
        $permission = $perms;
        return view('roles.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'permission' => 'required'
        ]);
        $input = $request->all();

        $role = new Role();
        $role->name = $input['name'];
        $role->display_name = $input['display_name'];
        $role->description = $input['description'];
        $role->save();

        Session::flash('success', 'Roles saved successfully.');

        $role->perms()->sync($input['permission']);

        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $roles = Role::find($id);

        if (empty($roles)) {
            Session::flash('error', 'Roles not found');
            return redirect()->route('roles.index');
        }

        $permission = Permission::get();
        $perms = [];
        $i = 0;
        foreach($permission as $perm) {
            $exp = explode("_", $perm->name);

            $perms[$exp[0]][$i] = $perm;

            $i++;
        }
        $permission = $perms;

        $rolePermission = DB::table('permission_role')->where('role_id',$id)->get();
        $_perm = [];
        foreach ($rolePermission as $key => $value) {
            $_perm[] = $value->permission_id;
        }
        $rolePermission = $_perm;

        return view('roles.edit', compact('roles', 'permission', 'rolePermission'));
    }
     
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'display_name' => 'required',
            'permission' => 'required'
        ]);
        $roles = Role::find($id);

        if (empty($roles)) {
            Session::flash('error', 'Roles not found');
            return redirect()->route('roles.index');
        }

        $input = $request->except(['_token', '_method']);
        $roles->save($input);

        $roles->perms()->sync($input['permission']);

        Session::flash('success', 'Roles updated successfully.');

        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        $roles = Role::find($id);

        if (empty($roles)) {
            Session::flash('error', 'Roles not found');
            return redirect()->route('roles.index');
        }

        $roles->delete();

        Session::flash('success', 'Roles deleted successfully.');

        return redirect()->route('roles.index');
    }
}
