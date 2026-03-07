@extends('layouts.master')

@push('title-modules', 'Master Kategori')

@push('style-css')

    <link href="{{ asset('templating/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endpush

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
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa fa-plus"></i> Tambah Data
                    </h6>
                </div>
                <form action="{{ url('/modules/kategori') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_kategori"> Nama Kategori </label>
                            <input type="text" name="nama_kategori" class="form-control" id="nama_kategori"
                                placeholder="Masukkan Nama Kategori">
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
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        DATA KATEGORI
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Nama Kategori</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomer = 0
                                @endphp
                                @foreach ($kategori as $item)
                                <tr>
                                    <td class="text-center">{{ ++$nomer }}.</td>
                                    <td>{{ $item['nama_kategori'] }}</td>
                                    <td class="text-center">
                                        @if ($item['is_active'] == "1")
                                            <span class="badge bg-success text-white text-uppercase">
                                                Aktif
                                            </span>
                                        @elseif ($item['is_active'] == "0")
                                            <span class="badge bg-danger text-white text-uppercase">
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('/modules/kategori/' . $item['id'] . '/change-status') }}" class="btn btn-{{ $item['is_active'] == "1" ? 'danger' : 'success' }} btn-sm">
                                            <i class="fa fa-{{ $item['is_active'] == '1' ? 'times' : 'check' }}"></i> {{ $item['is_active'] == "1" ? 'NON - AKTIFKAN' : 'AKITFKAN' }}
                                        </a>
                                        <a href="{{ url('/modules/kategori/' . $item['id'] . '/edit') }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> EDIT
                                        </a>
                                        <form action="{{ url('/modules/kategori/' . $item['id']) }}" method="POST" style="display: inline">
                                            @csrf
                                            @method("DELETE")
                                            <button onclick="return confirm('Yakin ? Ingin Menghapus Data Ini?')" type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> HAPUS
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('style-js')
    <script src="{{ asset('templating/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('templating/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templating/js/demo/datatables-demo.js') }}"></script>
@endpush
