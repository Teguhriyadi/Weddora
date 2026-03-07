<?php

namespace App\Http\Controllers\Report;

use App\Exports\HistoryGuest;
use App\Http\Controllers\Controller;
use App\Models\GuestCheckin;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HistoryGuestController extends Controller
{
    public function index()
    {
        try {

            DB::beginTransaction();

            $data["checkin"] = GuestCheckin::orderBy("created_at", "DESC")->get();

            DB::commit();

            return view("modules.report.history-guest.index", $data);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function download()
    {
        return Excel::download(new HistoryGuest, 'data-guest.xlsx');
    }
}
