@extends('layouts.master')

@push('title-modules', 'Master Tamu Undangan')

@push('content-modules')
    @if (session('success'))
        <div class="alert alert-success">
            <strong>Berhasil</strong>, {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            <strong>Gagal</strong>, {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <a href="{{ url('/modules/guest') }}" class="btn btn-danger btn-sm">
                        <i class="fa fa-sign-out-alt"></i> KEMBALI
                    </a>
                </div>
                <form action="{{ url('/modules/guest/' . $edit['id']) }}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="kategori_id" class="col-sm-2 col-form-label">Kategori Tamu</label>
                            <div class="col-sm-10">
                                <select name="kategori_id" class="form-control" id="kategori_id">
                                    <option value="">- Pilih -</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item['id'] }}" {{ $item['id'] == $edit['kategori_id'] ? 'selected' : '' }}>
                                            {{ $item['nama_kategori'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nama_tamu" class="col-sm-2 col-form-label">Nama Tamu</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_tamu" id="nama_tamu" placeholder="Masukkan Nama Tamu" value="{{ $edit['nama_tamu'] }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="keluarga" class="col-sm-2 col-form-label">Keluarga</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="keluarga" id="keluarga" placeholder="Masukkan Nama Keluarga" value="{{ $edit['keluarga'] }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="jumlah_undangan" class="col-sm-2 col-form-label">Jumlah Undangan</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="jumlah_undangan" id="jumlah_undangan" placeholder="0" min="1" value="{{ $edit['jumlah_undangan'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-times"></i> BATAL
                        </button>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-save"></i> SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
