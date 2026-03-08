@extends('layouts.master')

@push('title-modules', 'Input Kehadiran')

@push('style-css')
    <link href="{{ asset('templating/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('templating/select2/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
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
                <i class="fa fa-plus"></i> TAMBAH KEHADIRAN
            </h6>
        </div>
        <form action="{{ url('/modules/input-attendance') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="guest_id"> Nama Tamu </label>
                    <select name="guest_id" class="form-control select2 @error('guest_id') is-invalid @enderror" id="guest_id">
                        <option value="">- Pilih -</option>
                        @foreach ($guest as $item)
                            <option value="{{ $item['id'] }}">
                                ({{ $item['kategori']['nama_kategori'] }})
                                - {{ $item['nama_tamu'] }} - {{ $item['keluarga'] }}
                            </option>
                        @endforeach
                    </select>

                    @error('guest_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-plus"></i> TAMBAH KEHADIRAN
                </button>
            </div>
        </form>
    </div>

    <div class="card mt-3 d-none" id="infoGuest">
        <div class="card-body">
            <h5 class="mb-3">Informasi Tamu</h5>
            <div class="row">
                <div class="col-md-6">
                    <strong>Nama</strong>
                    <p id="guestNama"></p>
                </div>
                <div class="col-md-6">
                    <strong>Kategori</strong>
                    <p id="guestKategori"></p>
                </div>
                <div class="col-md-6">
                    <strong>Keluarga</strong>
                    <p id="guestKeluarga"></p>
                </div>
                <div class="col-md-6">
                    <strong>Jumlah Undangan</strong>
                    <p id="guestJumlah"></p>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('style-js')
    <script src="{{ asset('templating/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Pilih Nama Tamu'
            });
        });
    </script>

    <script>
        $('#guest_id').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        $('#guest_id').on('change', function() {

            let id = $(this).val();

            if (!id) return;

            $.get(`{{ url('/modules/guest/info') }}` + "/" + id, function(data) {

                $('#infoGuest').removeClass('d-none');

                $('#guestNama').text(data.nama);
                $('#guestKategori').text(data.kategori);
                $('#guestKeluarga').text(data.keluarga);
                $('#guestJumlah').text(data.jumlah);

            });

        });
    </script>
@endpush
