@extends('m_user/template')

@section('content')
<div class="row mt-5 mb-5">
        <div class="float-right">
            <a class="btn btn-secondary" href="{{ route('m_user.index') }}" style="background-color: #FF0000; color: white;">Kembali</a>

        </div>
</div>

<div class="card card-primary">
    <div class="card-header"  style="background-color: #ADD8E6; color: white;">
      <h3 class="card-title">Show User</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <strong><i class="fas fa-book mr-1"></i> User ID</strong>

      <p class="text-muted">
        {{ $useri->user_id }}
      </p>

      <hr>

      <strong><i class="fas fa-map-marker-alt mr-1"></i> Level ID</strong>

      <p class="text-muted">{{ $useri->level_id }}</p>

      <hr>

      <strong><i class="fas fa-pencil-alt mr-1"></i> Username</strong>

      <p class="text-muted">
        {{ $useri->username }}
      </p>

      <hr>

      <strong><i class="far fa-file-alt mr-1"></i> Nama</strong>

      <p class="text-muted">{{ $useri->nama }}</p>

      <hr>

      <strong><i class="far fa-file-alt mr-1"></i> Password</strong>

      <p class="text-muted">{{ $useri->password }}</p>
    </div>
    <!-- /.card-body -->
  </div>
@endsection

