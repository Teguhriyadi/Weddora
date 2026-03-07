@extends('layouts.master')

@push('title-modules', 'Master Tamu Undangan')

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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ url('/modules/guest/create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> TAMBAH DATA
            </a>
            <a href="{{ url('/modules/guest/download') }}" class="btn btn-success btn-sm">
                <i class="fa fa-download"></i> DOWNLOAD DATA
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Kategori</th>
                            <th>Kode Token</th>
                            <th>Nama Tamu</th>
                            <th>Keluarga</th>
                            <th>Jumlah Yang Diundang</th>
                            <th class="text-center">Status Kehadiran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomer = 0
                        @endphp
                        @foreach ($guest as $item)
                            <tr>
                                <td class="text-center">{{ ++$nomer }}.</td>
                                <td>{{ $item['kategori']['nama_kategori'] }}</td>
                                <td>{{ $item['kode_token'] }}</td>
                                <td>{{ $item['nama_tamu'] }}</td>
                                <td>{{ $item['keluarga'] }}</td>
                                <td>{{ $item['jumlah_undangan'] }}</td>
                                <td class="text-center">
                                    @if ($item['status_kehadiran'] == 0)
                                        <span class="badge bg-danger text-white text-uppercase">
                                            Belum Hadir
                                        </span>
                                    @elseif($item['status_kehadiran'] == 1)
                                        <span class="badge bg-success text-white text-uppercase">
                                            Sudah Hadir
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/modules/guest/' . $item['id'] . '/edit') }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> EDIT
                                    </a>
                                    <form action="{{ url('/modules/guest/' . $item['id']) }}" method="POST"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin ? Ingin Menghapus Data Ini?')" type="submit"
                                            class="btn btn-danger btn-sm">
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
@endpush

@push('style-js')
    <script src="{{ asset('templating/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('templating/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templating/js/demo/datatables-demo.js') }}"></script>
@endpush
