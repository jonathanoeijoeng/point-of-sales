<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = User::with('roles')->find($request->id);
        $roles = Role::all();

        return inertia('Settings/EditUser', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->active_until = $request->active_until;
        $user->syncRoles($request->role);
        $user->save();

        return redirect()->route('settings')->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'html' => 'User <b>' . $request->name . '</b> has been updated successfully',
                'type' => 'success',
            ],
        ]);
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();

        return redirect()->route('settings')->with([
            'flash' => [
                'title' => '<strong>Success!</strong>',
                'html' => 'User <b>' . $user->name . '</b> has been deleted successfully',
                'type' => 'success',
            ],
        ]);
    }
}
