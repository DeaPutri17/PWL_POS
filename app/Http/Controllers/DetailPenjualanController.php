<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use App\Models\BarangModel;
use App\Models\DetailPenjualanModel;
use App\Models\PenjualanModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class DetailPenjualanController extends Controller
{
    //menampilkan halaman awal detail penjualan
    public function index(){
        $breadcrumb = (object)[ 
            'title' => 'Daftar Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar transaksi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'detail';//set menu yang sedang aktif

        $penjualan = PenjualanModel::all(); //ambil data penjualan untuk filter penjualan

        return view('detail.index', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'penjualan'=>$penjualan, 'activeMenu'=>$activeMenu]);
    }

    // Ambil data detail penjualan dalam bentuk json untuk datatables
    public function list(Request $request){
        $details = DetailPenjualanModel::select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah')->with('penjualan', 'barang');

        //filter data detail berdasarkan penjualan_id
        if($request->penjualan_id){
            $details->where('penjualan_id', $request->penjualan_id);
        }

        return DataTables::of($details)
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        ->addColumn('aksi', function ($detail) { // menambahkan kolom aksi
        $btn = '<a href="'.url('/detail/' . $detail->detail_id).'" class="btn btn-info btn-sm">Detail</a> ';
        $btn .= '<a href="'.url('/detail/' . $detail->detail_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
        $btn .= '<form class="d-inline-block" method="POST" action="'. url('/detail/'.$detail->detail_id).'">'. csrf_field() . method_field('DELETE') . 
        '<button type="submit" class="btn btn-danger btn-sm" 
        onclick="return confirm(\'Apakah Anda yakit menghapus data 
        ini?\');">Hapus</button></form>'; 
        return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    //Menampilkan halaman form tambah detail
    public function create(){
        $breadcrumb = (object)[
            'title' => 'tambah detail',
            'list' => ['Home', 'Detail', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah detail baru'
        ];

        $penjualan = PenjualanModel::all(); //ambil data penjualan untuk ditampilkan di form
        $barang = BarangModel::all(); //ambil data barang untuk ditampilkan di form
        $activeMenu = 'detail'; //set menu yang sedang aktif

        return view('detail.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'barang' => $barang, 'activeMenu' => $activeMenu]);

    }

    //Menyimpan data detail baru
    public function store(Request $request){
        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id'    => 'required|integer',  
            'harga'        => 'required|integer',         
            'jumlah'       => 'required|integer'          
        ]);

        DetailPenjualanModel::create([
            'penjualan_id' => $request->penjualan_id,
            'barang_id'    => $request->barang_id,  
            'harga'        => $request->harga,         
            'jumlah'       => $request->jumlah,
        ]);

        return redirect('/detail')->with('success', 'Data detail berhasil disimpan');
    }

    //menampilkan detail penjualan
    public function show(string $id){
        $detail = DetailPenjualanModel::with('penjualan', 'barang')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail penjualan',
            'list' => ['Home', 'Detail Penjualan', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Penjualan'
        ];

        $activeMenu = 'detail'; //set menu yang sednag aktif

        return view('detail.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit userr
    public function edit(string $id){
        $detail = DetailPenjualanModel::find($id);
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit Detail', 
            'list' => ['Home', 'Detail', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Detail'
        ];

        $activeMenu = 'detail'; //set menu yang sednag aktif

        return view('detail.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'penjualan' => $penjualan, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data detail
    public function update(Request $request, string $id){

        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id'    => 'required|integer',  
            'harga'        => 'required|integer',         
            'jumlah'       => 'required|integer'  
        ]);

        DetailPenjualanModel::find($id)->update([
            'penjualan_id' => $request->penjualan_id,
            'barang_id'    => $request->barang_id,  
            'harga'        => $request->harga,         
            'jumlah'       => $request->jumlah,
        ]);

        return redirect('/detail')->with('success', 'Data detail berhasil diubah');
    }

    //menghapus data user
    public function destroy(string $id){
        $check = DetailPenjualanModel::find($id);
        if(!$check){//untuk mengecek apakah data detail dengan id yang dimaksud ada atau tidak
            return redirect('/detail')->with('error', 'Data detail tidak ditemukan');
        }

        try{
            DetailPenjualanModel::destroy($id); //hapus data detail

            return redirect('/detail')->with('success', 'Data detail berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/detail')->with('error', 'Data detail gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
