<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    //menampilkan halaman awal user
    public function index(){
        $breadcrumb = (object)[ 
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object)[
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';//set menu yang sedang aktif

        $kategori = KategoriModel::all(); //ambil data kategori untuk filter level

        return view('kategori.index', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'kategori'=>$kategori, 'activeMenu'=>$activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request){
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        //filter data kategori berdasarkan kategori_id
        if($request->kategori_id){
            $kategoris->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($kategoris)
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
        $btn = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> ';
        $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
        $btn .= '<form class="d-inline-block" method="POST" action="'. url('/kategori/'.$kategori->kategori_id).'">'. csrf_field() . method_field('DELETE') . 
        '<button type="submit" class="btn btn-danger btn-sm" 
        onclick="return confirm(\'Apakah Anda yakin menghapus data 
        ini?\');">Hapus</button></form>'; 
        return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    //Menampilkan halaman form tambah user
    public function create(){
        $breadcrumb = (object)[
            'title' => 'tambah kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah kategori baru'
        ];

        $kategori = KategoriModel::all(); //ambil data kategori untuk ditampilkan di form
        $activeMenu = 'kategori'; //set menu yang sedang aktif

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);

    }

    //Menyimpan data kategori baru
    public function store(Request $request){
        $request->validate([
            //kategori_kode harus diisi, berupa string minimal 3 karakter, dan bernilai unik di tabel m_kategori kolom kategori_kode
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100',  //nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);

            KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    //menampilkan detail kategori
    public function show(string $id){
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori'; //set menu yang sednag aktif

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit kategori
    public function edit(string $id){
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Kategori', 
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Kategori'
        ];

        $activeMenu = 'kategori'; //set menu yang sednag aktif

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data kategori
    public function update(Request $request, string $id){

        $request->validate([
            //kategori_kode harus diisi, berupa string minimal 3 karakter, dan bernilai unik di tabel m_kategori kolom kategori_kode
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,'.$id .',kategori_id',
            'kategori_nama' => 'required|string|max:100',  //nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    //menghapus data user
    public function destroy(string $id){
        $check = KategoriModel::find($id);
        if(!$check){//untuk mengecek apakah data kategori dengan id yang dimaksud ada atau tidak
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try{
            KategoriModel::destroy($id); //hapus data kategori

            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
  