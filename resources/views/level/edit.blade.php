@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Edit')
{{-- Content body: main page content --}}
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Level</h3>
            </div>

            <form method="post" action="../{{$data->level_id}}">
                
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="kodeLevel">Kode Level</label>
                        <input type="text" class="form-control" id="kodeLevel" name="kodeLevel" value="{{ $data->level_kode }}">
                    </div>
                    <div class="form-group">
                        <label for="namaLevel">Nama Level</label>
                        <input type="text" class="form-control" id="namaLevel" name="namaLevel" value="{{ $data->level_nama }}">
                    </div>
                </div>

                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>  
    </div>
@endsection