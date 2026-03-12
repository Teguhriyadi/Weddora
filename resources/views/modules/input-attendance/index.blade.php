@extends('layouts.master')

@push('title-modules', 'Input Kehadiran')

@push('style-css')
    <link href="{{ asset('templating/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('templating/select2/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />

    <style>
        .camera-wrapper {
            width: 320px;
            margin: auto;
            border-radius: 12px;
            overflow: hidden;
            border: 4px solid #f1f1f1;
            background: #000;
            position: relative;
        }

        #video {
            width: 100%;
        }

        #countdown {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 70px;
            font-weight: bold;
            color: white;
            text-shadow: 0 0 10px black;
            display: none;
        }

        #flash {
            position: absolute;
            width: 100%;
            height: 100%;
            background: white;
            opacity: 0;
        }

        .flash-animation {
            animation: flashEffect 0.3s;
        }

        @keyframes flashEffect {
            0% {
                opacity: 0
            }

            50% {
                opacity: 1
            }

            100% {
                opacity: 0
            }
        }
    </style>
@endpush


@push('content-modules')

    @if (session('success'))
        <div class="alert alert-success">
            <strong>Berhasil</strong>, {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            <strong>Gagal</strong>, {{ session('error') }}
        </div>
    @endif


    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fa fa-plus"></i> INPUT KEHADIRAN TAMU
            </h6>
        </div>

        <form action="{{ url('/modules/input-attendance') }}" method="POST">
            @csrf
            <input type="hidden" name="selfie" id="selfie">
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Tamu</label>
                    <select name="guest_id" id="guest_id"
                        class="form-control select2 @error('guest_id') is-invalid @enderror">
                    </select>
                    @error('guest_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body text-center">
                    <h5 class="mb-3">Selfie Tamu</h5>
                    <div id="cameraArea">
                        <div class="camera-wrapper mb-3">

                            <video id="video" autoplay playsinline></video>

                            <canvas id="canvas" style="display:none;"></canvas>

                            <div id="countdown"></div>

                            <div id="flash"></div>

                        </div>
                    </div>
                    <button type="button" id="btnSelfie" class="btn btn-primary btn-sm" onclick="takeSelfie()">
                        <i class="fa fa-camera"></i> Ambil Selfie
                    </button>
                    <div id="previewSelfie" class="mt-3"></div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-check"></i> CHECKIN TAMU
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
            $('#guest_id').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Ketik Nama Tamu',
                ajax: {
                    url: "{{ url('/modules/input-attendance/search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: `(${item.kategori}) ${item.nama_tamu} - ${item.keluarga ?? ''}`
                                };
                            })
                        };
                    }
                }
            });
        });

        $('#guest_id').on('change', function() {
            let id = $(this).val();
            if (!id) return;
            $.get(`{{ url('/modules/guest/info') }}/` + id, function(data) {
                $('#infoGuest').removeClass('d-none');
                $('#guestNama').text(data.nama);
                $('#guestKategori').text(data.kategori);
                $('#guestKeluarga').text(data.keluarga);
                $('#guestJumlah').text(data.jumlah);
            });
        });

        let shutter = new Audio("{{ asset('templating/sound/sound-selfie.mp3') }}");

        let video = document.getElementById('video');

        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function(stream) {
                video.srcObject = stream;
            })
            .catch(function() {
                alert("Kamera tidak bisa diakses");
            });

        let takingPhoto = false;

        function takeSelfie() {

            let selfie = document.getElementById("selfie").value;

            if (selfie) {
                resetSelfie();
                return;
            }

            if (takingPhoto) return;

            takingPhoto = true;

            let countdown = document.getElementById("countdown");

            let count = 3;

            countdown.style.display = "block";
            countdown.innerText = count;

            let timer = setInterval(() => {

                count--;

                if (count > 0) {

                    countdown.innerText = count;

                } else {

                    clearInterval(timer);

                    countdown.style.display = "none";

                    capturePhoto();

                    takingPhoto = false;

                }

            }, 1000);

        }

        function capturePhoto() {

            let canvas = document.getElementById("canvas");

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            let ctx = canvas.getContext("2d");

            ctx.drawImage(video, 0, 0);

            let image = canvas.toDataURL("image/png");

            document.getElementById("selfie").value = image;

            document.getElementById("previewSelfie").innerHTML =
                `<img src="${image}" width="250">`;

            shutter.play();

            let flash = document.getElementById("flash");

            flash.classList.add("flash-animation");

            setTimeout(() => {
                flash.classList.remove("flash-animation");
            }, 300);

            document.getElementById("cameraArea").style.display = "none";

            let btn = document.getElementById("btnSelfie");

            btn.innerHTML = `<i class="fa fa-refresh"></i> Ambil Selfie Terbaru`;

            btn.classList.remove("btn-primary");
            btn.classList.add("btn-warning");

        }

        function resetSelfie() {

            document.getElementById("previewSelfie").innerHTML = "";

            document.getElementById("selfie").value = "";

            document.getElementById("cameraArea").style.display = "block";

            let btn = document.getElementById("btnSelfie");

            btn.innerHTML = `<i class="fa fa-camera"></i> Ambil Selfie`;

            btn.classList.remove("btn-warning");
            btn.classList.add("btn-primary");

        }
    </script>

@endpush
