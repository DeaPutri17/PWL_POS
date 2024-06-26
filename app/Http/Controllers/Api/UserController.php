<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;

class UserController extends Controller
{
    public function index(){
        return UserModel::all();
    }

    public function store(Request $request){
        $user = UserModel::create([
            'level_id' => $request->level_id,
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
        ]);
        return response()->json($user, 201);
    }

    public function show(UserModel $user){
        return UserModel::find($user);
    }

    public function update(Request $request, UserModel $user){
        $user->update($request->all());
        return UserModel::find($user);
    }

    public function destroy(UserModel $user){
        $user->delete();

        return response()->json([
            'succes' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
