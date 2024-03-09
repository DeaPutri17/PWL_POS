<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index(){
        //tambah data user dengan Eloquent Model
        // $data = [
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2
        // ];
        // UserModel::insert($data); //tambahkan data ke tabel m_user
        $data = [
            'nama' => 'Manager ke-3',
        ];
        UserModel::where('username', 'manager_tiga')->update($data);//Update data user

        //coba akses model UserModel
        $user = userModel::all(); //ambil semua data dari tabel m_user
        return view('user', ['data'=>$user]);
    }
    
}
