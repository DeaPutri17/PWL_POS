@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Edit')
{{-- Content body: main page content --}}
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit kategori</h3>
            </div>

            <form method="post" action="../{{$data->kategori_id}}">
                
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="kodeKategori">Kode Kategori</label>
                        <input id = "kategori_kode" type="text" class="@error('kategori_kode') is-invalid @enderror" value="{{ $data->kategori_kode }}">

                        @error('kategori_kode')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="namaKategori">Nama Kategori</label>
                        <input id = "kategori_nama" type="text" class="@error('kategori_nama') is-invalid @enderror" value="{{ $data->kategori_nama }}">

                        @error('kategori_nama')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>  
    </div>
@endsection