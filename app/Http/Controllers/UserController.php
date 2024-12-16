<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function show($id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json($user, 200);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => Hash::make($request->password),
        ]);

        return response() -> json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
        ]);

        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
            'password' => isset($validated['password']) ? bcrypt($validated['password']) : $user->password,
        ]);

        return response() -> json([
            'message' => 'User updated successfully',
            'user' => $user,
        ], 200);
    }

    public function destroy($id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user -> delete();

        return response() -> json([
            'message' => $id.' - User deleted successfully',
        ], 200);
    }
}
