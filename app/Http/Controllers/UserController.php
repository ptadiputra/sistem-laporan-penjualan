<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function list() {
        return view('user/list', [
            "title" => "User",
            "users" => User::where('role', '!=', 'superadmin')->latest()->get()
        ]);
    }

    public function detail(User $user) {
        return view('user/detail', [
            "title" => "User",
            "user" => $user
        ]);
    }

    public function create() {
        return view('user/create', [
            "title" => "User",
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:5|max:255|unique:users',
            'password' => 'required|min:5|max:255',
            'confirm_password' => 'required|same:password',
            'no_tlp_user' => 'required|min:5|max:255|unique:users',
            'role' => 'required',
        ], [
            'confirm_password.same' => 'Bidang ini harus sama dengan password.',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect()->route('user.list')->with('success', 'Selamat, data berhasil disimpan.');
    }

    public function edit(User $user) {

        Log::debug($user);
        Log::debug("user");
        return view('user/edit', [
            "title" => "User",
            "user" => $user,
        ]);
    }

    public function update(Request $request, User $user) {
        $rules = [
            'name' => 'required|max:255',
            'username' => [
                'required', 'min:5', 'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'no_tlp_user' => [
                'required', 'min:5', 'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'role' => 'required',
        ];

        // -- Jika password diisi, tambahkan validasi untuk password dan confirm_password
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:5|max:255';
            $rules['confirm_password'] = 'required|same:password';
        }

        // -- Lakukan validasi dengan aturan yang ditentukan
        $validatedData = $request->validate($rules, [
            'confirm_password.same' => 'Bidang ini harus sama dengan password.',
        ]);

        // -- Jika password diisi, lakukan hashing
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        }

        // -- Update data user
        $user->update($validatedData);

        return redirect()->route('user.list')->with('success', 'Selamat, data berhasil diubah.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        session()->flash('success', 'Selamat, data berhasil dihapus.');
        return response()->json(['status' => 'success']);
    }
}
