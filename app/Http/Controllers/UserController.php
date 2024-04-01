<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class UserController extends Controller
{
    
    public function index(UserDataTable $dataTable){
            return $dataTable->render('user.index');
    }

    public function create(){
        return view('user.create');
    }

    public function store(Request $request){
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id
        ]);

        return redirect('/user');
    }

    public function edit($id){
        $user = UserModel::find($id);
        return view('user.edit', ['data' => $user]);
    }

    public function storeEdit($id, Request $request){
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make('$request->password');
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id){
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
}
