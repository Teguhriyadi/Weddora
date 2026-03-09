<?php

namespace App\Http\Controllers\InputManual;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuestPublic\CreateRequest;
use App\Http\Requests\GuestPublic\UpdateRequest;
use App\Models\GuestPublic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuestPublicController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data["guest_public"] = GuestPublic::orderBy("created_at", "DESC")->get();

            DB::commit();

            return view("modules.master.guest-public.index", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function create()
    {
        try {

            DB::beginTransaction();

            DB::commit();

            return view("modules.master.guest-public.create");

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function store(CreateRequest $request)
    {
        try {

            DB::beginTransaction();

            GuestPublic::create([
                "nama" => $request['nama'],
                "nomor_handphone" => $request["nomor_handphone"],
                "pekerjaan" => $request["pekerjaan"],
                "alamat" => $request["alamat"],
                "waktu_checkin" => now(),
                "users_id" => Auth::user()->id
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

            $data["edit"] = GuestPublic::where("id", $id)->first();

            DB::commit();

            return view("modules.master.guest-public.edit", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {

            DB::beginTransaction();

            GuestPublic::where("id", $id)->update([
                "nama" => $request['nama'],
                "nomor_handphone" => $request["nomor_handphone"],
                "pekerjaan" => $request["pekerjaan"],
                "alamat" => $request["alamat"],
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

            GuestPublic::where("id", $id)->delete();

            DB::commit();

            return back()->with("success", "Data Berhasil di Hapus");

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
