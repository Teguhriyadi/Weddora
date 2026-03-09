<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::where("nama_role", "Administrator")->first();
        $role_petugas = Role::where("nama_role", "Petugas")->first();

        User::create([
            "nama" => "Super Admin",
            "email" => "superadmin@test.com",
            "username" => "superadmin",
            "password" => bcrypt("password"),
            "role_id" => $role_admin->id
        ]);

        User::create([
            "nama" => "Puja Azzahrawani",
            "email" => "puja@test.com",
            "username" => "puja123",
            "password" => bcrypt("password"),
            "role_id" => $role_petugas->id
        ]);

        User::create([
            "nama" => "Test Akun Lagi",
            "email" => "dewinta@gmail.com",
            "username" => "caca123",
            "password" => bcrypt("password"),
            "role_id" => $role_petugas->id
        ]);
    }
}
