<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/tambah', [UserController::class, 'tambah']);    
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);   
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
// Route::get('kategori', [KategoriController::class, 'index']);
// Route::get('/kategori/create', [KategoriController::class, 'create']);
// Route::post('/kategori', [KategoriController::class, 'store']);
// Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit']);
// Route::put('/kategori/{id}', [KategoriController::class, 'storeEdit']);
// Route::get('/kategori/hapus/{id}', [KategoriController::class, 'hapus'])->name('kategori.hapus');
//Manage User
// Route::get('/user/create', [UserController::class, 'create']);
// Route::post('/user', [UserController::class, 'store']);
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/edit/{id}', [UserController::class, 'edit']);
// Route::put('/user/{id}', [UserController::class, 'storeEdit']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
//Manage Level
// Route::get('/level/create', [LevelController::class, 'create']);
// Route::post('/level', [LevelController::class, 'store']);
// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/level/edit/{id}', [LevelController::class, 'edit']);
// Route::put('/level/{id}', [LevelController::class, 'storeEdit']);
// Route::get('/level/hapus/{id}', [LevelController::class, 'hapus']);

// Route::resource('m_user', POSController::class);

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index']);          //menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);   //menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);         //menyimpan data user baru
    Route::get('/{id}', [UserController::class, 'show']);       //menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);  //menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);     //menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']); //menghapus data user
});

Route::group(['prefix' => 'level'], function(){
    Route::get('/', [LevelController::class, 'index']);          //menampilkan halaman awal Level
    Route::post('/list', [LevelController::class, 'list']);      //menampilkan data Level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);   //menampilkan halaman form tambah Level
    Route::post('/', [LevelController::class, 'store']);         //menyimpan data Level baru
    Route::get('/{id}', [LevelController::class, 'show']);       //menampilkan detail Level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);  //menampilkan halaman form edit Level
    Route::put('/{id}', [LevelController::class, 'update']);     //menyimpan perubahan data Level
    Route::delete('/{id}', [LevelController::class, 'destroy']); //menghapus data Level
});

Route::group(['prefix' => 'kategori'], function(){
    Route::get('/', [KategoriController::class, 'index']);          //menampilkan halaman awal Kategori
    Route::post('/list', [KategoriController::class, 'list']);      //menampilkan data Kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);   //menampilkan halaman form tambah Kategori
    Route::post('/', [KategoriController::class, 'store']);         //menyimpan data Kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']);       //menampilkan detail Kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);  //menampilkan halaman form edit Kategori
    Route::put('/{id}', [KategoriController::class, 'update']);     //menyimpan perubahan data Kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']); //menghapus data Kategori
});