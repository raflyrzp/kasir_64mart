<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Identitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function adminIndex()
    {
        $role = auth()->user()->role;
        $data_admin = User::where('role', 'admin')->get();
        $identitas = Identitas::findOrFail(1);

        return view('data_user.data_admin.index', [
            'title' => 'Admins',
            'data_admin' => $data_admin,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }
    public function kasirIndex()
    {
        $role = auth()->user()->role;
        $data_kasir = User::where('role', 'kasir')->get();
        $identitas = Identitas::findOrFail(1);

        return view('data_user.data_kasir.index', [
            'title' => 'Cashiers',
            'data_kasir' => $data_kasir,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }
    public function ownerIndex()
    {
        $role = auth()->user()->role;
        $data_owner = User::where('role', 'owner')->get();
        $identitas = Identitas::findOrFail(1);

        return view('data_user.data_owner.index', [
            'title' => 'Owners',
            'data_owner' => $data_owner,
            'role' => $role,
            'identitas' => $identitas,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'in:admin,owner,kasir',
            'password' => 'required|min:6',
            'nisn' => 'nullable|numeric'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'nisn' => $request->nisn,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('data_' . $request->role)->with('success', 'Successfully added a new ' . $request->role . '.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'in:admin,owner,kasir',
            'password' => 'nullable|min:5',
            'nisn' => 'nullable|numeric'
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('data_admin')->with('error', 'User not found.');
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->nisn = $request->nisn;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('data_' . $request->role)->with('success', 'Successfully updated a ' . $request->role . '.');
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return redirect()->route('data_' . $request->role)->with('success', 'Successfully deleted a user.');
    }
}
