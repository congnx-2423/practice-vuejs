<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function store(Request $request)
    {
        $newUserData = $request->only(['name', 'email']);
        $newUserData = array_merge($newUserData, ['password' => Hash::make(12345678)]);
        $user = User::create($newUserData);

        return response()->json([
            'code' =>Response::HTTP_OK,
            'newUser' => $user
        ]);
    }

    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return response()->json([
            'users' => $users,
            'code' =>Response::HTTP_OK,
        ]);
    }

    public function update(Request $request, $id)
    {
        $inputData = $request->only(['name', 'email']);
        $user = User::findOrFail($id);
        $user->update($inputData);

        return response()->json([
           'code' => Response::HTTP_OK,
            'user' => $user,
        ]);
    }

    public function destroy($id)
    {
        $user = User::destroy($id);

        return response()->json([
            'code' => Response::HTTP_OK,
        ]);
    }
}
