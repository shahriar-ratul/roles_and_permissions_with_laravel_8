<?php

namespace App\Http\Controllers\Management;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Role $role)
    {

        $this->role = $role;
        $this->user = Auth::user();
    }
    public function index()
    {
        $roles = $this->role::all();
        return view('admin.role.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (is_null($this->user) || !$this->user->can('role.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized to create any role !');
        // }
        $all_permissions  = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.role.create', compact('all_permissions', 'permission_groups'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'                  => 'required|string|unique:roles',
            'display_name'          => 'required|string|unique:roles',
            'permissions'           => 'nullable'
        ]);

        $role = $this->role->create([
            'name' => $request->name,
            'display_name' => $request->display_name
        ]);

        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return response()->json("Roles Created", 200);
    }

    public function getAll()
    {
        $roles = $this->role->all();
        return response()->json([
            'roles' => $roles
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (is_null($this->user) || !$this->user->can('role.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to edit any role !');
        // }

        $role = $this->role::find($id);
        $all_permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.role.edit', compact('role', 'all_permissions', 'permission_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'                  => 'required|string|unique:roles,name,'.$id,
            'display_name'          => 'required|string|unique:roles,name,'.$id,
            'permissions'           => 'required'
        ]);

        $this->role = $this->role::find($id);
        $role = $this->role->update([
            'name'          => $request->name,
            'display_name'  => $request->display_name
        ]);


        $permissions = $request->input('permissions');
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }


        return response()->json(['message' =>"Roles Updated"], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('role.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any Role !');
        }
        $role = Role::findorfail($id);
        if (!is_null($role)) {
            $role->delete();
            $success = true;
            $message = "Role deleted successfully";
        }else {
            $success = true;
            $message = "Role not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
