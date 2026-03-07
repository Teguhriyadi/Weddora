<?php

namespace App\Exports;

use App\Models\GuestCheckin;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HistoryGuest implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
{
    protected $guest;

    public function title(): string
    {
        return 'Data Riwayat Undangan Kehadiran';
    }

    public function collection()
    {
        $this->guest = GuestCheckin::with(["guest", "guest.kategori"])->get();
        return $this->guest;
    }

    public function headings(): array
    {
        return [
            'Kategori Tamu',
            'Nama Tamu',
            'Keluarga',
            'Metode',
            'Tanggal Waktu'
        ];
    }

    public function map($guest): array
    {
        return [
            $guest->guest->kategori->nama_kategori,
            $guest->guest->nama_tamu,
            $guest->guest->keluarga,
            $guest->metode,
            Carbon::parse($guest['waktu_checkin'])->locale('id')->translatedFormat('d F Y H:i:s')
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 15,
            'C' => 25,
            'D' => 20,
            'E' => 15
        ];
    }
}
