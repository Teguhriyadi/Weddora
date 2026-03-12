<?php

namespace App\Http\Controllers\QRCode;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\GuestCheckin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ScanQRGuestController extends Controller
{
    public function index()
    {
        return view("modules.scan-qr-guest.index");
    }

    public function store(Request $request)
    {
        $guest = Guest::where('kode_token', $request->kode_token)->first();

        if (!$guest) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak valid'
            ]);
        }

        $sudahCheckin = GuestCheckin::where('guest_id', $guest->id)->exists();

        if ($sudahCheckin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode sudah digunakan'
            ]);
        }

        $selfiePath = null;

        if ($request->selfie) {

            $image = $request->selfie;

            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);

            $fileName = "selfie_" . time() . ".png";

            Storage::disk('public')->put(
                "selfie/" . $fileName,
                base64_decode($image)
            );

            $selfiePath = $fileName;
        }

        GuestCheckin::create([
            'guest_id' => $guest->id,
            'metode' => 'qr',
            'waktu_checkin' => now(),
            'users_id' => Auth::user()->id,
            "selfie_path" => $selfiePath,
        ]);

        $guest->update([
            "status_kehadiran" => 1
        ]);

        return response()->json([
            'status' => 'success',
            'nama' => $guest->nama_tamu
        ]);
    }
}
