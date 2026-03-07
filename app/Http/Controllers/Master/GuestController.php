<?php

namespace App\Http\Controllers\Master;

use App\Exports\GuestExport;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Guest;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GuestController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data["guest"] = Guest::orderBy("created_at", "DESC")->get();

            DB::commit();

            return view("modules.master.guest.index", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function create()
    {
        try {

            DB::beginTransaction();

            $data["kategori"] = Kategori::get();

            DB::commit();

            return view("modules.master.guest.create", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $event = Event::first();

            $token = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, rand(6,8));

            Guest::create([
                "event_id" => $event["id"],
                "kategori_id" => $request["kategori_id"],
                "kode_token" => $token,
                "nama_tamu" => $request["nama_tamu"],
                "keluarga" => $request["keluarga"],
                "jumlah_undangan" => $request["jumlah_undangan"]
            ]);

            DB::commit();

            return back()->with("success", "Data Berhasil di Tambahkan");

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {

            DB::beginTransaction();

            $data["kategori"] = Kategori::get();
            $data["edit"] = Guest::where("id", $id)->first();

            DB::commit();

            return view("modules.master.guest.edit", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            Guest::where("id", $id)->update([
                "kategori_id" => $request["kategori_id"],
                "nama_tamu" => $request["nama_tamu"],
                "keluarga" => $request["keluarga"],
                "jumlah_undangan" => $request["jumlah_undangan"]
            ]);

            DB::commit();

            return back()->with("success", "Data Berhasil di Simpan");

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            DB::beginTransaction();

            Guest::where("id", $id)->delete();

            DB::commit();

            return back()->with("success", "Data Berhasil di Hapus");

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function change_status($id)
    {
        try {

            DB::beginTransaction();

            $kategori = Kategori::where("id", $id)->first();

            if ($kategori['is_active'] == "1") {
                $kategori->update([
                    "is_active" => "0"
                ]);
            } else if ($kategori['is_active'] == "0") {
                $kategori->update([
                    "is_active" => "1"
                ]);
            }

            DB::commit();

            return back()->with("success", "Data Berhasil di Simpan");

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function download()
    {
        return Excel::download(new GuestExport, 'data-guest.xlsx');
    }
}
