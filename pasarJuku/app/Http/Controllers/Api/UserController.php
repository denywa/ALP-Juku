<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // public function index()
    // {
    //     $users = User::all();
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Users retrieved successfully',
    //         'data' => $users
    //     ], 200);
    // }

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
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'role' => 'required|string|max:15',
            'image' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $users = User::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $users
        ], 201);
    }

//     public function update(Request $request, $id)
//     {
//     $validator = Validator::make($request->all(), [
//         'name' => 'required|string|max:255',
//         'email' => 'required|string|email|max:255|unique:users,email,' . ($id ?? ''),
//         'password' => 'required|string|min:8',
//         'id_role' => 'required|integer|exists:roles,id_role',
//         'phone' => 'required|string|max:15',
//         'image' => 'nullable|url',
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Validation error',
//             'errors' => $validator->errors()
//         ], 422);
//     }

//         // Cari user berdasarkan ID
//     $user = User::findOrFail($id);

//     // Update data user
//     $data = $request->all();
//     if ($request->has('password')) {
//         $data['password'] = bcrypt($request->password); // Encrypt password jika diubah
//     } else {
//         unset($data['password']); // Jangan ubah password jika tidak diberikan
//     }
//     $user->update($data);

//     // Kembalikan response sukses
//     return response()->json([
//         'status' => true,
//         'message' => 'User updated successfully',
//         'data' => $user
//     ], 200);
// }


    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ], 204);
    }
}

