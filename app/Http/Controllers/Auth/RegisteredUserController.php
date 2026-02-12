<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;

class RegisteredUserController extends Controller
{ 
    // GET /v1/users
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    // GET /v1/users/{user}
    public function show(User $user)
    {
        return new UserResource($user);
    }

    // GET /v1/users/roles/{role}
    public function getByRole($role)
    {
        $users = User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();

        return UserResource::collection($users);
    }  


    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|string|exists:roles,name', // validate role exists
        ]);

        // Generate a random 8-character password
        $generatedPassword = Str::random(8);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($generatedPassword),
        ]);

        // Assign role
        $user->assignRole($request->role);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'role' => $request->role,
            'password' => $generatedPassword, // return the generated password so admin can send it
        ], 201);
    }
}
