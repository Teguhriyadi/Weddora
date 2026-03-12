@extends('layouts.master')

@push('title-modules', 'Scan QR Code Tamu')

@push('style-css')
    <style>
        .card {
            border: none;
            border-radius: 20px;
        }

        .card-header {
            background: white;
            border-bottom: none;
        }

        .camera-wrapper {
            width: 320px;
            margin: auto;
            border-radius: 20px;
            overflow: hidden;
            border: 5px solid white;
            background: #000;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        #video {
            width: 100%;
            height: auto;
        }

        #reader {
            border: 4px dashed #ddd;
            border-radius: 15px;
            padding: 10px;
            background: white;
        }

        #countdown {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 80px;
            font-weight: bold;
            color: white;
            text-shadow: 0 0 10px black;
            display: none;
        }

        #flash {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            opacity: 0;
            pointer-events: none;
        }

        .flash-animation {
            animation: flashEffect 0.3s;
        }

        #previewSelfie img {
            border-radius: 10px;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            border: 4px solid white;
        }

        .scan-line {
            position: absolute;
            width: 100%;
            height: 4px;
            background: red;
            top: 0;
            animation: scanMove 2s infinite;
        }

        @keyframes scanMove {
            0% {
                top: 0
            }

            100% {
                top: 100%
            }
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

        .welcome-text {
            font-size: 26px;
            font-weight: bold;
            color: #444;
        }

        .sub-text {
            color: #777;
        }
    </style>
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
        <div class="card-header py-3 text-center">
            <div class="welcome-text">
                🎉 Selamat Datang 🎉
            </div>
            <div class="sub-text">
                Silahkan Scan QR Undangan Anda
            </div>
        </div>

        <div class="card-body text-center">
            <div id="reader" style="width:350px;margin:auto;"></div>
            <hr>
            <h6 class="mt-3">Selfie Tamu</h6>
            <div id="cameraArea">
                <div class="camera-wrapper mb-3">
                    <video id="video" autoplay playsinline></video>
                    <div class="scan-line"></div>
                    <canvas id="canvas" style="display:none;"></canvas>
                    <div id="countdown"></div>
                    <div id="flash"></div>
                </div>
            </div>

            <div id="previewSelfie"></div>

            <button type="button" id="btnSelfie" class="btn btn-primary btn-sm" onclick="takeSelfie()">
                <i class="fa fa-camera"></i> Ambil Selfie
            </button>

            <input type="hidden" name="selfie" id="selfie">
            <div id="previewSelfie"></div>
            <div id="result" class="mt-3"></div>

        </div>
    </div>
@endpush

@push('style-js')
    <script src="https://unpkg.com/html5-qrcode"></script>
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
            let countdownEl = document.getElementById("countdown");
            let count = 3;
            countdownEl.style.display = "block";
            countdownEl.innerText = count;

            let timer = setInterval(() => {
                count--;
                if (count > 0) {
                    countdownEl.innerText = count;
                } else {
                    clearInterval(timer);
                    countdownEl.style.display = "none";
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

        let scanning = true;

        function onScanSuccess(decodedText) {
            if (!scanning) return;
            let selfie = document.getElementById("selfie").value;
            if (!selfie) {
                alert("Silahkan ambil selfie terlebih dahulu");
                return;
            }

            scanning = false;

            fetch("{{ url('/modules/scan-qr-guest') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        kode_token: decodedText,
                        selfie: selfie
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {

                        document.getElementById("result").innerHTML =
                            `<div class="alert alert-success">
🎉 <b>Terima Kasih ${data.nama}</b><br>
Telah Hadir di Acara Pernikahan Kami
</div>`;
                        setTimeout(() => {
                            resetSelfie();
                            document.getElementById("result").innerHTML = "";
                        }, 3000);
                    }

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
