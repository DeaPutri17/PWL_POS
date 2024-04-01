@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Create')
{{-- Content body: main page content --}}
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Buat User baru</h3>
            </div>

            <form method="post" action="../user">
                <div class="card-body">
                    <div class="form-group">
                        <label for="usernameUser">Username</label>
                        <input id="username"
                            type="text" 
                            name="username"
                            class="@error('username') is-invalid @enderror"  placeholder="Masukkan Username">

                            @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="namaUser">Nama</label>
                        <input id="nama"
                            type="text" 
                            name="nama"
                            class="@error('nama') is-invalid @enderror"  placeholder="Masukkan Nama">

                            @error('nama')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password"
                            type="text" 
                            name="password"
                            class="@error('password') is-invalid @enderror"  placeholder="Masukkan Password">

                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="idLevel">ID Level</label>
                        <input id="level_id"
                            type="text" 
                            name="level_id"
                            class="@error('level_id') is-invalid @enderror"  placeholder="Masukkan Level ID">

                            @error('level_id')
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