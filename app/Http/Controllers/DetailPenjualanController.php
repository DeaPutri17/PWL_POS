<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use App\Models\BarangModel;
use App\Models\DetailPenjualanModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class DetailPenjualanController extends Controller
{
    //menampilkan halaman awal detail penjualan
    public function index(){
        $breadcrumb = (object)[ 
            'title' => 'Daftar Transaksi Penjualan',
            'list' => ['Home', 'Transaski Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar transaksi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'detail';//set menu yang sedang aktif

        $user = UserModel::all(); //ambil data penjualan untuk filter penjualan

        return view('detail.index', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'user'=>$user, 'activeMenu'=>$activeMenu]);
    }

    // Ambil data detail penjualan dalam bentuk json untuk datatables
    public function list(Request $request){
        $transactions = PenjualanModel::select('penjualan_id', 'user_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal')->with('user');

        //filter data detail berdasarkan user_id
        if($request->user_id){
            $transactions->where('user_id', $request->user_id);
        }

        return DataTables::of($transactions)
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        ->addColumn('aksi', function ($detail) { // menambahkan kolom aksi
        $btn = '<a href="'.url('/detail/' . $detail->penjualan_id).'" class="btn btn-info btn-sm">Detail</a> ';
        $btn .= '<a href="'.url('/detail/' . $detail->penjualan_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
        $btn .= '<form class="d-inline-block" method="POST" action="'. url('/detail/'.$detail->penjualan_id).'">'. csrf_field() . method_field('DELETE') . 
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
            'title' => 'Tambah Transaksi',
            'list' => ['Home', 'Transaksi Penjualan', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah transaksi baru'
        ];

        $user = UserModel::all(); //ambil data user untuk ditampilkan di form
        $barang = BarangModel::all(); //ambil data barang untuk ditampilkan di form
        $activeMenu = 'detail'; //set menu yang sedang aktif

        $counter = (PenjualanModel::selectRaw("CAST(RIGHT(penjualan_kode, 3) AS UNSIGNED) AS counter")->orderBy('penjualan_id', 'desc')->value('counter')) + 1;
        $penjualan_kode = 'PJ' . sprintf("%04d", $counter);
        $total = 0;

        return view('detail.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'barang' => $barang, 'penjualan_kode' =>$penjualan_kode, 'activeMenu' => $activeMenu, 'date' => date("Y-m-d"),
        'total' => $total]);


    }

    //Menyimpan data detail baru
    public function store(Request $request){
        $request->validate([
            'user_id'       => 'required|integer',
            'penjualan_kode'=> 'required|string|unique:t_penjualan,penjualan_kode',
            'pembeli'       => 'required|string|max:100',
            'barang_id.*'    => 'required|integer',  
            'harga.*'        => 'required|integer',         
            'jumlah.*'       => 'required|integer'          
        ]);

        $total = 0;

        foreach ($request->barang_id as $key => $barang_id) {

            $stok = StokModel::where('barang_id', $barang_id)->value('stok_jumlah');
            $nama_barang = BarangModel::where('barang_id', $barang_id)->value('barang_nama');
            $requestedQuantity = $request->jumlah[$key];

            if ($stok < $requestedQuantity) {
                return redirect()->back()->withInput()->withErrors(['jumlah.' . $key => 'Jumlah Melebihi Stok yang Tersedia. Stok "' . $nama_barang . '" Saat Ini: ' . $stok]);
            }

            $total += $request->jumlah[$key] * $request->harga[$key];
        }

        $detail = PenjualanModel::create([
            'user_id' => $request->user_id,
            'penjualan_kode' => $request->penjualan_kode,
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => now(),
        ]);

        // t_penjualan_detail
        $barang_ids = $request->barang_id;
        $jumlahs = $request->jumlah;
        $hargas = $request->harga;

        foreach ($barang_ids as $key => $barang_id) {
            DetailPenjualanModel::create([
                'penjualan_id' => $detail->penjualan_id,
                'barang_id' => $barang_id,
                'harga' => $hargas[$key],
                'jumlah' => $jumlahs[$key],
            ]);

            $stok = (StokModel::where('barang_id', $barang_id)->value('stok_jumlah')) - $jumlahs[$key];
            $date = date('Y-m-d');
            StokModel::where('barang_id', $barang_id)->update(['stok_jumlah' => $stok, 'stok_tanggal' => $date, 'user_id' => $request->user_id]);
        }

        return redirect('/detail')->with('success', 'Data detail berhasil disimpan');
    }

    //menampilkan detail penjualan
    public function show(string $id){
        $detail = PenjualanModel::find($id);
        $penjualan_detail = DetailPenjualanModel::where('penjualan_id', $id)->get();

        $breadcrumb = (object)[
            'title' => 'Detail penjualan',
            'list' => ['Home', 'Detail Transaksi Penjualan', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Penjualan'
        ];

        $activeMenu = 'detail'; //set menu yang sednag aktif

        return view('detail.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'penjualan_detail' => $penjualan_detail, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit transaksi
    public function edit(string $id){
        $detail = PenjualanModel::find($id);
        $user = UserModel::all();
        $barang = BarangModel::with('stok')->get();

        $breadcrumb = (object)[
            'title' => 'Edit Detail', 
            'list' => ['Home', 'Detail', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Detail'
        ];

        $activeMenu = 'detail'; //set menu yang sednag aktif

        return view('detail.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'user' => $user, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data detail
    public function update(Request $request, string $id){

        $request->validate([
            'user_id'      => 'required|integer',
            'penjualan_kode' => 'required|string|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
            'pembeli'      => 'required|string|max:100',
            'barang_id.*'    => 'required|integer',  
            'harga.*'        => 'required|integer',         
            'jumlah.*'       => 'required|integer'  
        ]);

        $transaksi = PenjualanModel::findOrFail($id);

        $transaksi->update([
            'user_id' => $request->user_id,
            'penjualan_kode' => $request->penjualan_kode,
            'pembeli' => $request->pembeli,
        ]);

        $transaksi->detail()->delete();

        foreach ($request->barang_id as $key => $barang_id) {
            $transaksi->detail()->create([
                'barang_id' => $barang_id,
                'harga' => $request->harga[$key],
                'jumlah' => $request->jumlah[$key],
            ]);
        }

        return redirect('/detail')->with('success', 'Data detail berhasil diubah');
    }

    //menghapus data user
    public function destroy(string $id){
        $penjualan = PenjualanModel::find($id);
        if (!$penjualan) {
            return redirect('/detail')->with('error', 'Data detail tidak ditemukan');
        }
    
        try {
            // Assume `details` is a relationship storing related records
            $penjualan->detail()->delete();  // Delete related records first
            $penjualan->delete();  // Now delete the main record
    
            return redirect('/detail')->with('success', 'Data detail berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/detail')->with('error', 'Data detail gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    
    
}
