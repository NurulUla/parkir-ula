<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('role')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $role = session('role');

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        } elseif ($role === 'owner') {
            return redirect()->route('owner.dashboard');
        }
    }

    public function dashboardAdmin()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        return $this->renderUtamaView();
    }

    public function dashboardPetugas()
    {
        if (!session()->has('role') || session('role') !== 'petugas') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        return $this->renderUtamaView();
    }

    public function dashboardOwner()
    {
        if (!session()->has('role') || session('role') !== 'owner') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        return $this->renderUtamaView();
    }

    private function renderUtamaView()
    {
        $kendaraan_aktif = DB::table('tb_transaksi')->where('status', 'masuk')->count();
        $total_kapasitas = DB::table('tb_area_parkir')->sum('kapasitas') ?? 0;
        
        $slot_tersedia = $total_kapasitas - $kendaraan_aktif;
        if ($slot_tersedia < 0) {
            $slot_tersedia = 0;
        }

        $pendapatan_hari_ini = DB::table('tb_transaksi')
            ->where('status', 'keluar')
            ->whereDate('waktu_keluar', date('Y-m-d'))
            ->sum('biaya_total') ?? 0;

        return view('utama', compact('kendaraan_aktif', 'slot_tersedia', 'pendapatan_hari_ini'));
    }
}
