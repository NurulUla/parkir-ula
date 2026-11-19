<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // SUDAH DITAMBAHKAN: Mengatasi error DB not found

class OwnerDashboardController extends Controller
{
    // =========================================================================
    // 📊 HALAMAN UTAMA / DASHBOARD OWNER
    // =========================================================================
    public function index()
    {
        if (!session()->has('role') || session('role') !== 'owner') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }

        // Ambil data statistik dari database
        $kendaraan_aktif = \DB::table('tb_transaksi')->where('status', 'masuk')->count();
        $total_kapasitas = \DB::table('tb_area_parkir')->sum('kapasitas') ?? 0;
        
        $slot_tersedia = $total_kapasitas - $kendaraan_aktif;
        if ($slot_tersedia < 0) $slot_tersedia = 0;

        $pendapatan_hari_ini = \DB::table('tb_transaksi')
            ->where('status', 'keluar')
            ->whereDate('waktu_keluar', date('Y-m-d'))
            ->sum('biaya_total') ?? 0;

        return view('utama', compact('kendaraan_aktif', 'slot_tersedia', 'pendapatan_hari_ini'));
    }

    // =========================================================================
    // 📈 MANAJEMEN & REKAP LAPORAN PENDAPATAN
    // =========================================================================
    public function rekapLaporan(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'owner') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $query = DB::table('tb_transaksi')
            ->join('tb_kendaraan', 'tb_transaksi.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->where('tb_transaksi.status', 'keluar');

        // Filter rentang waktu (opsional, dikirim lewat ?dari=YYYY-MM-DD&sampai=YYYY-MM-DD)
        if ($request->filled('dari')) {
            $query->whereDate('tb_transaksi.waktu_keluar', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tb_transaksi.waktu_keluar', '<=', $request->sampai);
        }

        $laporan = $query->orderBy('tb_transaksi.waktu_keluar', 'desc')->get();
        $total_pendapatan = $laporan->sum('biaya_total');

        return view('owner.rekap', compact('laporan', 'total_pendapatan'));
    }
}
