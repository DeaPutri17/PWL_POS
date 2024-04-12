@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
    <div class="card-body">
    @empty($detail)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        <a href="{{ url('detail') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
            <form method="POST" action="{{ url('/detail/'.$detail->detail_id) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT') !!} <!-- tambahkan baris ini untuk proses edit yang butuh method PUT -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Penjualan</label>
                <div class="col-11">
                    <select class="form-control" id="penjualan_id" name="penjualan_id" required>
                        <option value="">- Pilih ID Penjualan -</option>
                        @foreach($penjualan as $item)
                            <option value="{{ $item->penjualan_id }}" @if($item->penjualan_id == $detail->penjualan_id) selected @endif>{{ $item->penjualan_id }}</option>
                        @endforeach 
                    </select>
                    @error('penjualan_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Barang</label>
                <div class="col-11">
                    <select class="form-control" id="barang_id" name="barang_id" required>
                        <option value="">- Pilih ID Barang -</option>
                        @foreach($barang as $item)
                            <option value="{{ $item->barang_id }}" @if($item->barang_id == $detail->barang_id) selected @endif>{{ $item->barang_id }}</option>
                        @endforeach 
                    </select>
                    @error('barang_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Harga</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga', $detail->harga) }}" required>
                    @error('harga')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Jumlah</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', $detail->jumlah) }}" required>
                    @error('jumlah')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('detail') }}">Kembali</a>
                </div>
            </div>
            </form>
        @endempty
    </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush