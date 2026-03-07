<?php

namespace App\Http\Controllers\InputManual;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\GuestCheckin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InputAttendanceController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data["guest"] = Guest::get();

            DB::commit();

            return view("modules.input-attendance.index", $data);
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $guest = Guest::where("id", $request["guest_id"])->first();

            $sudahCheckin = GuestCheckin::where('guest_id', $guest->id)->exists();

            if ($sudahCheckin) {
                return back()->with("error", "Nama Tamu " . $guest['nama_tamu'] . ' Sudah Masuk ke Dalam Acara');
            }

            GuestCheckin::create([
                "guest_id" => $guest["id"],
                "metode" => "manual",
                "waktu_checkin" => now(),
                "users_id" => Auth::user()->id
            ]);

            Guest::where("guest_id", $request["guest_id"])->update([
                "status_kehadiran" => 1
            ]);

            DB::commit();

            return back()->with("success", "Data Berhasil di Tambahkan");
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
