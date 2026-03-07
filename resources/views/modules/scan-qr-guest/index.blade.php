@extends('layouts.master')

@push('title-modules', 'Scan QR Code Tamu')

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
                <i class="fa fa-plus"></i> Tambah Data
            </h6>
        </div>
        <form action="{{ url('/modules/kategori') }}" method="POST">
            @csrf
            <div class="card-body text-center">
                <div id="reader" style="width:350px; margin:auto;"></div>

                <div id="result" class="mt-3"></div>
            </div>
        </form>
    </div>
@endpush

@push('style-js')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let scanning = true;

        function onScanSuccess(decodedText) {

            if (!scanning) return;

            scanning = false;

            fetch("{{ url('/modules/scan-qr-guest') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        kode_token: decodedText
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === "success") {

                        document.getElementById("result").innerHTML =
                            `<div class="alert alert-success">
                <b>Terima Kasih ${data.nama}</b> Telah Hadir di Acara Pernikahan Kami. Selamat Menikmati Hidangan yang Telah Tersedia
            </div>`;

                    } else {

                        document.getElementById("result").innerHTML =
                            `<div class="alert alert-danger">
                ${data.message}
            </div>`;

                    }

                    // aktifkan scan lagi setelah 3 detik
                    setTimeout(() => {
                        scanning = true;
                    }, 3000);

                });

        }

        function onScanFailure(error) {}

        let scanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: 250
            }
        );

        scanner.render(onScanSuccess, onScanFailure);
    </script>
@endpush
