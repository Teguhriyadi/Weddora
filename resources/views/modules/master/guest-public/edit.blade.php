@extends('layouts.master')

@push('title-modules', 'Edit Data Tamu')

@push('style-css')
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

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <a href="{{ url('/modules/guest-public') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> KEMBALI
                    </a>
                </div>

                <form action="{{ url('/modules/guest-public/' . $edit['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="selfie" id="selfie">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Nama Tamu <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        name="nama" value="{{ old('nama', $edit['nama']) }}"
                                        placeholder="Masukkan Nama Tamu">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No. Handphone</label>
                                    <input type="text" class="form-control" name="nomor_handphone"
                                        value="{{ old('nomor_handphone', $edit['nomor_handphone']) }}"
                                        placeholder="Masukkan Nomor Handphone">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" class="form-control" name="pekerjaan"
                                        value="{{ old('pekerjaan', $edit['pekerjaan']) }}" placeholder="Masukkan Pekerjaan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="4" placeholder="Masukkan Alamat">{{ old('alamat', $edit['alamat']) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="camera-title">
                                            Selfie Tamu
                                        </div>
                                        <div id="cameraArea">
                                            <div class="camera-wrapper mb-3">

                                                <video id="video" autoplay playsinline></video>

                                                <canvas id="canvas" style="display:none;"></canvas>

                                                <div id="countdown"></div>

                                                <div id="flash"></div>

                                            </div>
                                        </div>
                                        <button type="button" id="btnSelfie" class="btn btn-primary btn-sm"
                                            onclick="takeSelfie()">
                                            <i class="fa fa-camera"></i> Ambil Foto Baru
                                        </button>
                                        <div id="previewSelfie" class="mt-3">
                                            @if ($edit['selfie_path'])
                                                <img src="{{ Storage::disk('s3')->url('selfie/'.$edit->selfie_path) }}"
                                                    width="200">
                                            @endif
                                        </div>
                                    </div>
                                </div>
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

@push('style-js')
    <script>
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
