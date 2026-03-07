<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data["role"] = Role::orderBy("created_at", "DESC")->get();

            DB::commit();

            return view("modules.master.role.index", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function store(CreateRequest $request)
    {
        try {

            DB::beginTransaction();

            Role::create([
                "nama_role" => $request->nama_role
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

            $data["role"] = Role::where("id", "!=", $id)->orderBy("created_at", "DESC")->get();
            $data["edit"] = Role::where("id", $id)->first();

            DB::commit();

            return view("modules.master.role.edit", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {

            DB::beginTransaction();

            Role::where("id", $id)->update([
                "nama_role" => $request["nama_role"]
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

            Role::where("id", $id)->delete();

            DB::commit();

            return back()->with("success", "Data Berhasil di Hapus");

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
