@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('detail/create') }}">Tambah</a>
            </div>
        </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" id="penjualan_id" name="penjualan_id" required>
                            <option value="">- Semua -</option>
                            @foreach ($penjualan as $item)
                                <option value="{{ $item->penjualan_id }}">{{ $item->penjualan_id }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Penjualan ID</small>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm"id="table_detailPenjualan">
            <thead>
                <tr><th>Detail ID</th><th>Penjualan ID</th><th>Nama Pembeli</th><th>Barang</th><th>Harga</th><th>Jumlah</th><th>Total</th><th>Aksi</th></tr>
            </thead>
        </table>
    </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            var dataUser = $('#table_detailPenjualan').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('detail/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d){
                        d.penjualan_id = $('#penjualan_id').val();
                    }
                },
                columns: [
                    {
                        data: "detail_id", // nomor urut dari laravel datatable addIndexColumn()
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },{
                        data: "penjualan.penjualan_id", 
                        className: "",
                        orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                        searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                    },{
                        data: "penjualan.pembeli", 
                        className: "",
                        orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                        searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                    },{
                        data: "barang.barang_nama", 
                        className: "",
                        orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                        searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                    },{
                        data: "harga", 
                        className: "",
                        orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                        searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                    },{
                        data: "jumlah", 
                        className: "",
                        orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                        searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                    },{
                        data: null, 
                        className: "",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Menghitung total dengan mengalikan harga dan jumlah
                            return row.harga * row.jumlah;
                        }
                    },{
                        data: "aksi", 
                        className: "",
                        orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                        searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                    }
                ]
            });

            $('#penjualan_id').on('change', function(){
                dataDetail.ajax.reload();
            });
        });
    </script>
@endpush
