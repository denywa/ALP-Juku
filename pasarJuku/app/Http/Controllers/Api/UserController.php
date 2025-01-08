<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => true,
            'message' => 'Users retrieved successfully',
            'data' => $users
        ], 200);
    }

    public function show($id)
    {
        $users = User::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'User found successfully',
            'data' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Validasi gambar
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Default nilai untuk nama gambar
        $imageName = null;

        // Cek apakah gambar diunggah
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('profile-image', $imageName, 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'customer', // Default role to 'customer' if not provided
            'phone' => $request->phone,
            'image' => $imageName, // Simpan nama file atau null jika tidak ada gambar
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete('profile-image/' . $user->image);
            }
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('profile-image', $imageName, 'public');
            $user->image = $imageName;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->fill($request->except(['password', 'image']));
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ], 204);
    }

    public function getMyData(){
        $userData = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'User profile retrieved successfully',
            'data' => $userData
        ], 200);
    }
}
