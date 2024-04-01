<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable){
        return $dataTable->render('kategori.index');
    }

    public function create(){
        return view('kategori.create');
    }

    public function store(Request $request):RedirectResponse{
        $validated = $request->validate([
            'kategori_kode' => 'bail|required|unique:post|max:255',
            'kategori_nama' => 'bail|required|unique:post|max:255',
        ]);
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'namaKategori' => $request->namaKategori,
        ]);
        //The post is valid
        return redirect('/kategori');
    }

    public function edit($id){
        $kategori = KategoriModel::find($id);
        return view('kategori.edit', ['data' => $kategori]);
    }

    public function storeEdit(Request $request, $id){
        $kategori = KategoriModel::find($id);

        $kategori->kategori_kode = $request->kodeKategori;
        $kategori->kategori_nama = $request->namaKategori;
        $kategori->save();

        return redirect('/kategori');
    }

    public function hapus($id){
        $kategori = KategoriModel::find($id);
        $kategori->delete($id);

        return redirect('/kategori');
    }

}
