<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        // $data = [
        //     'nama' => 'Manager ke-3',
        // ];
        // UserModel::where('username', 'manager_tiga')->update($data);//Update data user

        // $data = [
        //     'level_id' => 2,
        //     //'username' => 'manager_dua',
        //     //'nama' => 'Manager 2',
        //     'username' => 'manager_empat',
        //     'nama' => 'Manager 3    ',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        //$user = UserModel::find(1);
        //$user = UserModel::where('level_id', 1)->first();
        // $user = UserModel::firstWhere('level_id', 1);
        //coba akses model UserModel
        //$user = userModel::all(); //ambil semua data dari tabel m_user
        // $user = UserModel::findOr(20, ['username', 'nama'], function(){
        //     abort(404);
        // });
        //$user = UserModel::findOrFail(1);
        // $user = UserModel::where('username', 'manager9')->firstOrFail();
        $user = UserModel::where('level_id', 2)->count();
        //dd($user);
        return view('user', ['data'=>$user]);
    }
    
}
