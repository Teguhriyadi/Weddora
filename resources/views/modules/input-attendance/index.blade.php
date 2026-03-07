@extends('layouts.master')

@push('title-modules', 'Input Kehadiran')

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
                <i class="fa fa-plus"></i> TAMBAH KEHADIRAN
            </h6>
        </div>
        <form action="{{ url('/modules/input-attendance') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="guest_id"> Nama Tamu </label>
                    <select name="guest_id" class="form-control" id="guest_id">
                        <option value="">- Pilih -</option>
                        @foreach ($guest as $item)
                            <option value="{{ $item['id'] }}">
                                {{ $item['nama_tamu'] }} - {{ $item['keluarga'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-plus"></i> TAMBAH KEHADIRAN
                </button>
            </div>
        </form>
    </div>
@endpush
