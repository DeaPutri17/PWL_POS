<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar Stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok';       //set menu yang sedang aktif
        $stok = StokModel::all();   //UNTUK FILTERING
        $user = UserModel::all();   //UNTUK FILTERING
        return view('stok.index', [
            'breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $stok = StokModel::with(['user', 'barang'])->select('*');

        //Filter data stok berdasarkan stok_id
        if ($request->barang_id) {
            $stok->where('barang_id', $request->barang_id);
        }
        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">' . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'tambah stok',
            'list' => ['Home', 'stok', 'tambah']
        ];
        $page = (object) [
            'title' => 'tambah stok baru'
        ];

        $stok = StokModel::all();      //ambil data stok untuk ditampilkan di form
        $activeMenu = 'stok';          //set menu yang sedang aktif
        $barang = BarangModel::all();
        $user = UserModel::all();
        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request){
    $request->validate([
        'barang_id' => 'required|int',
        'user_id' => 'required|int',
        'stok_tanggal' => 'required',
        'stok_jumlah' => 'required|int',
    ]);

    // Cek apakah ada stok sebelumnya untuk barang yang sama
    $existingStok = StokModel::where('barang_id', $request->barang_id)->latest()->first();

    if ($existingStok) {
        // Jika ada stok sebelumnya, tambahkan jumlah stok baru ke jumlah stok yang sudah ada
        $existingStok->update([
            'stok_jumlah' => $existingStok->stok_jumlah + $request->stok_jumlah,
        ]);
    } else {
        // Jika tidak ada stok sebelumnya, buat stok baru
        StokModel::create([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
        ]);
    }

    return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    public function show(string $id)
    {
        $stok = StokModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail stok'
        ];

        $activeMenu = 'stok'; //set menu yang sedang aktif

        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $stok = StokModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit stok'

        ];

        $activeMenu = 'stok'; ///set menu yang aktif
        $barang = BarangModel::all();
        $user = UserModel::all();
        return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_id' => 'required|int',
            'user_id' => 'required|int',
            'stok_tanggal' => 'required',
            'stok_jumlah' => 'required',
        ]);

        StokModel::find($id)->update([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
        ]);
        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = StokModel::find($id);
        if (!$check) {                  //untuk mengecek apakah data sesuai dengan id yang dimaksud ada atau tidak
            return redirect('/stok')->with('error', 'Data tidak ditemukan');
        }

        try {
            StokModel::destroy($id);    //Hapus data 

            return redirect('/stok')->with('success', 'Data berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            //Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/stok')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkai dengan data ini');
        }
    }
}