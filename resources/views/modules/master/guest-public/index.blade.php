@extends('layouts.master')

@push('title-modules', 'Master Tamu Luar')

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
            <a href="{{ url('/modules/guest-public/create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> TAMBAH DATA
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nama Tamu</th>
                            <th>No. Handphone</th>
                            <th>Pekerjaan</th>
                            <th>Alamat</th>
                            <th class="text-center">Waktu Checkin</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomer = 0;
                        @endphp
                        @foreach ($guest_public as $item)
                            <tr>
                                <td class="text-center">{{ ++$nomer }}.</td>
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ $item['nomor_handphone'] }}</td>
                                <td>{{ $item['pekerjaan'] }}</td>
                                <td>{{ $item['alamat'] }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item['waktu_checkin'])->locale('id')->translatedFormat('d F Y H:i:s') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('/modules/guest-public/' . $item['id'] . '/edit') }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> EDIT
                                    </a>
                                    <form action="{{ url('/modules/guest-public/' . $item['id']) }}" method="POST"
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
