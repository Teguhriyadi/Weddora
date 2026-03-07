@extends('layouts.master')

@push('title-modules', 'Riwayat Tamu Undangan')

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
            <h6 class="m-0 font-weight-bold text-primary">
                DATA RIWAYAT KEHADIRAN
            </h6>
        </div>
        <div class="card-body">
            <a href="{{ url('/modules/history-guest/download') }}" class="btn btn-primary btn-sm mb-3">
                <i class="fa fa-download"></i> DOWNLOAD DATA
            </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama Kategori</th>
                            <th>Nama Tamu</th>
                            <th>Keluarga</th>
                            <th class="text-center">Metode</th>
                            <th class="text-center">Tanggal Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomer = 0
                        @endphp
                        @foreach ($checkin as $item)
                        <tr>
                            <td class="text-center">{{ ++$nomer }}.</td>
                            <td class="text-center">{{ $item['guest']['kategori']['nama_kategori'] }}</td>
                            <td>{{ $item['guest']['nama_tamu'] }}</td>
                            <td>{{ $item['guest']['keluarga'] }}</td>
                            <td class="text-center text-uppercase">{{ $item['metode'] }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($item['waktu_checkin'])->locale('id')->translatedFormat('d F Y H:i:s') }}
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
