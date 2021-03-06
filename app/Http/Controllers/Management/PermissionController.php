<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
        $this->user = Auth::user();
        $this->middleware(['auth', 'role_or_permission:superadmin|admin|permission.view|permission.create|permission.edit|permission.delete']);
    }

    public function index()
    {
        $this->user =  Auth::user();
        if (is_null($this->user) || !$this->user->can('permission.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any Permission !');
        }
        $permissions = $this->permission::all();

        return view("admin.permission.index", ['permissions' => $permissions]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->user =  Auth::user();
        if (is_null($this->user) || !$this->user->can('permission.create')) {
            abort(403, 'Sorry !! You are Unauthorized to Create any Permission !');
        }
        return view("admin.permission.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->user =  Auth::user();
        if (is_null($this->user) || !$this->user->can('permission.create')) {
            abort(403, 'Sorry !! You are Unauthorized to Create any Permission !');
        }
        $this->validate($request, [
            'display_name'  => 'required',
            'group_name'    => 'required',
            'name'          => 'required|unique:permissions'
        ]);

        $this->permission->create([
            'name'          => $request->name,
            'group_name'    => $request->group_name,
            'display_name'  => $request->display_name
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->user =  Auth::user();
        if (is_null($this->user) || !$this->user->can('permission.view')) {
            abort(403, 'Sorry !! You are Unauthorized to View any Permission !');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->user =  Auth::user();
        if (is_null($this->user) || !$this->user->can('permission.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to Update any Permission !');
        }

        $item = Permission::find($id);
        return view("admin.permission.edit",compact('item'));
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
        $this->user =  Auth::user();
        if (is_null($this->user) || !$this->user->can('permission.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to Update any Permission !');
        }

        $this->validate($request, [
            'display_name'  => 'required|unique:permissions,display_name,'.$id,
            'group_name'    => 'required',
            'name'          => 'required|unique:permissions,name,'.$id,
        ]);

        $this->permission = Permission::find($id);
        $this->permission->update([
            'display_name'  => $request->display_name,
            'group_name'    => $request->group_name,
            'name'          => $request->name,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('permission.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any permission !');
        }
        $permission = Permission::findorfail($id);
        if (!is_null($permission)) {
            $permission->delete();
            $success = true;
            $message = "Permission deleted successfully";
        }else {
            $success = true;
            $message = "Permission not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }



    public function getAllPermissions()
    {
        $permissions = $this->permission::all();

        return response()->json([
            'permissions' => $permissions
        ], 200);
    }

    public function getAll()
    {
        $permissions = $this->permission->all();
        return response()->json([
            'permissions' => $permissions
        ], 200);
    }
}
