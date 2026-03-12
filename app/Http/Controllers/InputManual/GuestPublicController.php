<?php

namespace App\Http\Controllers\InputManual;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuestPublic\CreateRequest;
use App\Http\Requests\GuestPublic\UpdateRequest;
use App\Models\GuestPublic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

            $filename = null;

            if ($request->selfie) {

                $image = $request->selfie;

                $image = str_replace('data:image/png;base64,', '', $image);
                $image = base64_decode($image);

                $filename = "selfie_" . time() . ".png";

                Storage::put("selfie/" . $filename, $image);
            }

            GuestPublic::create([
                "nama" => $request['nama'],
                "nomor_handphone" => $request["nomor_handphone"],
                "pekerjaan" => $request["pekerjaan"],
                "alamat" => $request["alamat"],
                "waktu_checkin" => now(),
                "users_id" => Auth::user()->id,
                "selfie_path" => $filename,
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

            $guest = GuestPublic::findOrFail($id);

            $selfiePath = $guest->selfie_path;

            if ($request->selfie) {

                if ($guest->selfie_path) {
                    Storage::disk('public')->delete('selfie/' . $guest->selfie_path);
                }

                $image = $request->selfie;
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);

                $fileName = 'selfie_' . time() . '.png';

                Storage::disk('public')->put(
                    'selfie/' . $fileName,
                    base64_decode($image)
                );

                $selfiePath = $fileName;
            }

            $guest->update([
                'nama' => $request->nama,
                'nomor_handphone' => $request->nomor_handphone,
                'pekerjaan' => $request->pekerjaan,
                'alamat' => $request->alamat,
                'selfie_path' => $selfiePath
            ]);

            DB::commit();

            return back()->with("success", "Data berhasil di simpan");
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            DB::beginTransaction();

            $cek = GuestPublic::where("id", $id)->first();

            if ($cek->selfie_path) {
                Storage::disk('public')->delete('selfie/' . $cek->selfie_path);
            }

            $cek->delete();

            DB::commit();

            return back()->with("success", "Data Berhasil di Hapus");
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
