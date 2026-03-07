@extends('layouts.master')

@push('title-modules', 'Master Role')

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
                        <i class="fa fa-plus"></i> TAMBAH DATA
                    </h6>
                </div>
                <form action="{{ url('/modules/role') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_role">
                                Nama Role
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_role" class="form-control @error('nama_role') is-invalid @enderror" id="nama_role"
                                placeholder="Masukkan Nama Role" value="{{ old('nama_role') }}">

                            @error('nama_role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
                        DATA ROLE
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Nama Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomer = 0
                                @endphp
                                @foreach ($role as $item)
                                <tr>
                                    <td class="text-center">{{ ++$nomer }}.</td>
                                    <td>{{ $item['nama_role'] }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/modules/role/' . $item['id'] . '/edit') }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> EDIT
                                        </a>
                                        <form action="{{ url('/modules/role/' . $item['id']) }}" method="POST" style="display: inline">
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
