<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|regex:/^[6-9][0-9]{9}$/|size:10',
            'role_id' => 'required|exists:roles,id',
            'profile_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description,
            'role_id' => $request->role_id,
            'profile_image' => $imagePath ?? null
        ]);

        $data = $request->all();

        return response()->json(['message' => 'Form submitted successfully!']);
    }

    public function index()
    {
        $users = User::with('role')->get();
        return response()->json($users);
    }

    public function showForm()
    {
        $roles = Role::all();
        return view('users', compact('roles'));
    }

}
