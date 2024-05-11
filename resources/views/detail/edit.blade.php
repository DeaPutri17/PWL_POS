@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('detail/' . $detail->penjualan_id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="user_id">User:</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($user as $u)
                            <option value="{{ $u->user_id }}" {{ $u->user_id == $detail->user_id ? 'selected' : '' }}>{{ $u->username }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="penjualan_kode">Kode Penjualan:</label>
                    <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" value="{{ old('penjualan_kode', $detail->penjualan_kode) }}" required>
                </div>

                <div class="form-group">
                    <label for="pembeli">Pembeli:</label>
                    <input type="text" name="pembeli" id="pembeli" class="form-control" value="{{ old('pembeli', $detail->pembeli) }}" required placeholder="Masukkan Nama Pembeli">
                </div>

                <!-- Form untuk detail transaksi (barang_id, harga, jumlah) -->
                {{-- @foreach ($transaksi->detail as $detail)
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Barang</label>
                        <div class="col-11">
                            <select class="form-control" name="barang_id[]" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->barang_id }}" {{ $item->barang_id == $detail->barang_id ? 'selected' : '' }}>{{ $item->barang_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Harga</label>
                        <div class="col-11">
                            <input type="number" class="form-control" name="harga[]" value="{{ $detail->harga }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Jumlah</label>
                        <div class="col-11">
                            <input type="number" class="form-control" name="jumlah[]" value="{{ $detail->jumlah }}" required>
                        </div>
                    </div>
                @endforeach --}}

                @foreach ($detail->detail as $detail)
                <div class="form-barang">
                    <div class="card-header">
                        <h3 class="card-title">Detail Transaksi Barang</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-danger btn-sm hapusBarang">Hapus</button>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="barang_id">Barang</label>
                        <select class="form-control" name="barang_id[]" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->barang_id }}" {{ $item->barang_id == $detail->barang_id ? 'selected' : '' }}>{{ $item->barang_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga[]" value="{{ $detail->harga }}" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah[]" value="{{ $detail->jumlah }}" required>
                    </div>
                </div>
            @endforeach

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('detail') }}" class="btn btn-default ml-1">Kembali</a>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tambahkan form barang secara dinamis saat tombol "Tambah Barang" ditekan
            $('#tambahBarang').click(function() {
                var formBarang = $('#formBarang').clone();
                formBarang.find('input').val('');
                $('#formBarangContainer').append(formBarang);
            });
            // Hitung total harga setiap kali terjadi perubahan pada input jumlah atau harga
            $('#formBarangContainer').on('input', 'input[name^="harga"], input[name^="jumlah"]', function() {
                var total = 0;
                $('.form-barang').each(function() {
                    var harga = $(this).find('input[name="harga[]"]').val() || 0;
                    var jumlah = $(this).find('input[name="jumlah[]"]').val() || 0;
                    total += harga * jumlah;
                });
                $('#totalTransaksi').text('Rp. ' + total);
            });
            // Inisialisasi hitung total saat halaman dimuat
            $('#formBarangContainer input').trigger('input');
        });
    </script>
@endpush