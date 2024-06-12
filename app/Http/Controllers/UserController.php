<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();

        return view('user.index', [
            'users' => $users,
        ]);    }
    public function create()
    {
        return view('user.create');
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return redirect()->route('user.index')->with('success', 'Запис успішно створено');
    }

    public function edit($id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->first();
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Запис не знайдено');
        }
        return view('user.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }
    public function destroy($id)
    {
        try {
            DB::table('users')->where('id', $id)->delete();
            return redirect()->route('user.index')->with('success', 'Користувача успішно видалено');
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'Виникла помилка при видаленні користувача');
        }
    }
}
