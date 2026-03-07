<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data["users"] = User::orderBy("created_at", "DESC")->get();

            DB::commit();

            return view("modules.master.users.index", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function create()
    {
        try {

            DB::beginTransaction();

            $data["role"] = Role::get();

            DB::commit();

            return view("modules.master.users.create", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            User::create([
                "nama" => $request['nama'],
                "username" => $request["username"],
                "email" => $request["email"],
                "password" => bcrypt("password"),
                "role_id" => $request['role_id']
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

            $data["role"] = Role::get();
            $data["edit"] = User::where("id", $id)->first();

            DB::commit();

            return view("modules.master.users.edit", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            User::where("id", $id)->update([
                "nama" => $request['nama'],
                "username" => $request["username"],
                "email" => $request["email"],
                "role_id" => $request['role_id']
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

            User::where("id", $id)->delete();

            DB::commit();

            return back()->with("success", "Data Berhasil di Hapus");

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
