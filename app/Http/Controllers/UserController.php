<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function _login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');

        try {
            // Cek apakah autentikasi berhasil
            if (Auth::attempt($credentials, $remember)) {
                Log::info('User logged in', ['username' => $request->input('username')]);
                return redirect()->route('dashboard')->with('success', 'Login successful');
            }

            // Jika gagal, log error dan kirim kembali ke halaman login dengan pesan error
            Log::warning('Failed login attempt', ['username' => $request->input('username')]);
            return back()->withErrors(['login' => 'Username or password is incorrect'])->withInput();
        } catch (\Exception $e) {
            Log::error('Login error', ['message' => $e->getMessage()]);
            return back()->withErrors(['login' => 'An unexpected error occurred. Please try again later.'])->withInput();
        }
    }


    public function index(Request $request)
    {
        $users = User::where("level", "!=", "super-admin")->get();

        return view('pages.user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'username' => 'required|string|min:3|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->level = 'user';
        $user->password = bcrypt($request->input('password'));
        if ($user->save()) {
            return redirect()->route('user.index')->with('success', 'User created successfully');
        }
        return back()->withErrors(['error' => 'Failed to create user'])->withInput();
    }

    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'username' => 'required|string|min:3|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        if ($user->save()) {
            return redirect()->route('user.index')->with('success', 'User updated successfully');
        }
        return back()->withErrors(['error' => 'Failed to update user'])->withInput();
    }

    public function destroy($id)
    {
        $user =  User::find($id);
        if ($user->delete()) {
            return redirect()->route('user.index')->with('success', 'User deleted successfully');
        }
        return back()->withErrors(['error' => 'Failed to delete user']);
    }

    // permission
    public function permissions()
    {
        $getRoles = Role::orderBy('id', 'desc')->get();
        $getPermissions = Permission::orderBy('id', 'desc')->get();

        if (request()->get('role')) {
            // cek role and permssion checked
            $role = Role::findById(request()->get('role'));
            $getPermissions->map(function ($permission) use ($role) {
                $permission->checked = $role->hasPermissionTo($permission);
                return $permission;
            });
        }

        return view('pages.role-permission', [
            'roles' => $getRoles,
            'permissions' => $getPermissions
        ]);
    }

    // role store
    public function storeRole(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255',
        ]);
        if (Role::create(['name' => $request->input('role')]))
            return redirect()->route('user.permissions')->with('success', 'Role created successfully');

        return back()->withErrors(['error' => 'Failed to create role'])->withInput();
    }

    public function destroyRole($id)
    {
        $role = Role::find($id);
        if ($role->delete()) {
            return redirect()->route('user.permissions')->with('success', 'Role deleted successfully');
        }
        return back()->withErrors(['error' => 'Failed to delete role']);
    }

    //setPermission
    public function setPermission(Request $request)
    {
        $role = Role::findById($request->input('role'));
        $permission = Permission::findById($request->input('permission'));
        if ($request->input('checked')) {
            $role->givePermissionTo($permission);
        } else {
            $role->revokePermissionTo($permission);
        }
        return response()->json(['message' => 'success']);
    }
    //setUserRole
    public function getUserRole($id)
    {
        $users = User::where('id', $id)->first();
        $roles = Role::all();
        $roles->map(function ($role) use ($users) {
            $role->checked = $users->hasRole($role);
            return $role;
        });
        return view('pages.user-role', compact('users', 'roles'));
    }

    public function setUserRole(Request $request)
    {
        // role_id: role_id,
        // checked: checked
        $user = User::find($request->input('user_id'));
        $role = Role::findById($request->input('role_id'));
        if ($request->input('checked')) {
            $user->assignRole($role);
        } else {
            $user->removeRole($role);
        }
        return response()->json(['message' => 'success']);
    }
}
