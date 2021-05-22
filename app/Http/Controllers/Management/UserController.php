<?php

namespace App\Http\Controllers\Management;

use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware(['auth', 'role_or_permission:superadmin|admin|user.view|user.create|user.edit|user.delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(UsersDataTable $dataTable)
    {
        $this->user =  Auth::user();
        if (is_null($this->user) || !$this->user->can('user.view')) {
            abort(403, 'Sorry !! You are Unauthorized to View any User !');
        }

        return $dataTable->render('admin.users.index');
    }
    // public function index()
    // {
    //     return view('admin.user.index');
    // }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->user =  Auth::user();
        if (is_null($this->user) || !$this->user->can('user.create')) {
            abort(403, 'Sorry !! You are Unauthorized to Create any User !');
        }
        $roles = Role::all();
        return view("admin.users.edit",compact('roles'))->with('item',new User());
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
            'name'      => 'required|string',
            'password'  => 'required|alpha_num|min:6',
            'role'      => 'required',
            'email'     => 'required|email|unique:users'
        ]);

        $roles = [];
        if($request->role){
            $roles = $request->role;
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        foreach($roles as $role){
            $user->assignRole($role);
        }

        if ($request->has('permissions')) {
            $user->givePermissionTo($request->permissions);
        }

        $user->save();

        session()->flash('success', 'User has been created !!');
        // return response()->json("User Created", 200);
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        if (is_null($this->user) || !$this->user->can('user.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to Edit any User !');
        }
        $item = User::find($id);
        $roles = Role::all();
        return view("admin.users.edit",compact('roles','item'));
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
            'name'          => 'required|string',
            'password'      => 'nullable|alpha_num|min:6',
            'role'          => 'required',
            'email'         => 'required|email|unique:users,email,' . $id
        ]);

        $roles = [];
        if($request->role){
            $roles = $request->role;
        }

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }


        if ($request->has('role')) {
            $userRole = $user->getRoleNames();
            foreach ($userRole as $role) {
                $user->removeRole($role);
            }

            foreach($roles as $role){
                $user->assignRole($role);
            }

        }

        if ($request->has('permissions')) {
            $userPermissions = $user->getPermissionNames();
            foreach ($userPermissions as $permssion) {
                $user->revokePermissionTo($permssion);
            }

            $user->givePermissionTo($request->permissions);
        }


        $user->save();

        return response()->json('ok', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('user.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any permission !');
        }
        $user = User::findorfail($id);
        if (!is_null($user)) {
            $user->delete();
            $success = true;
            $message = "User deleted successfully";
        }else {
            $success = false;
            $message = "User not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }



    /////////////////////// User defined Method

    public function getAll()
    {
        $users = User::latest()->get();
        $users->transform(function ($user) {
            $user->role = $user->getRoleNames()->first();
            $user->userPermissions = $user->getPermissionNames();
            return $user;
        });

        return response()->json([
            'users' => $users
        ], 200);
    }

    public function profile()
    {
        return view("admin.profile.index");
    }

    public function postProfile(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);

        $user->update($request->all());

        return redirect()->back()->with('success', 'Profile Successfully Updated');
    }

    public function getPassword()
    {
        return view('admin.profile.password');
    }

    public function postPassword(Request $request)
    {

        $this->validate($request, [
            'newpassword' => 'required|min:6|max:30|confirmed'
        ]);

        $user = auth()->user();

        $user->update([
            'password' => bcrypt($request->newpassword)
        ]);

        return redirect()->back()->with('success', 'Password has been Changed Successfully');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json('ok', 200);
    }

    public function search(Request $request)
    {
        $searchWord = $request->get('s');
        $users = User::where(function ($query) use ($searchWord) {
            $query->where('name', 'LIKE', "%$searchWord%")
                ->orWhere('email', 'LIKE', "%$searchWord%");
        })->latest()->get();

        $users->transform(function ($user) {
            $user->role = $user->getRoleNames()->first();
            $user->userPermissions = $user->getPermissionNames();
            return $user;
        });

        return response()->json([
            'users' => $users
        ], 200);
    }
}
