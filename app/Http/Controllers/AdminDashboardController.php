<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   // SUDAH DITAMBAHKAN: Agar tidak error 'DB not found'
use Illuminate\Support\Facades\Hash; // SUDAH DITAMBAHKAN: Agar tidak error 'Hash not found'

class AdminDashboardController extends Controller
{
    // =========================================================================
    // 📊 HALAMAN UTAMA / DASHBOARD ADMIN
    // =========================================================================
    public function index()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
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
    // 🛠️ MANAJEMEN PENGGUNA (CRUD USER)
    // =========================================================================

    public function crudUser()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $users = DB::table('tb_user')->get();
        return view('admin.users', compact('users'));
    }

    public function simpanUser(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:tb_user,username',
            'password' => 'required|min:6',
            'role' => 'required'
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah dipakai, silakan pilih username lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Hak akses (role) wajib dipilih.'
        ]);

        DB::table('tb_user')->insert([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => strtolower($request->username),
            'password' => Hash::make($request->password), 
            'role' => $request->role,
            'status_aktif' => 1
        ]);

        return redirect()->route('admin.user')->with('success', 'User baru berhasil terdaftar!');
    }

    public function hapusUser($id)
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        if ($id == session('user_id')) {
            return redirect()->route('admin.user')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif!');
        }

        DB::table('tb_user')->where('id_user', $id)->delete();
        return redirect()->route('admin.user')->with('success', 'Akun pengguna berhasil dihapus dari sistem!');
    }

    // =========================================================================
    // 💰 MANAJEMEN TARIF PARKIR
    // =========================================================================

    public function crudTarif()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $tarif = DB::table('tb_tarif')->get();
        return view('admin.tarif', compact('tarif'));
    }

    // =========================================================================
    // 🗺️ MANAJEMEN AREA PARKIR
    // =========================================================================

    public function crudArea()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $area = DB::table('tb_area_parkir')->get();
        return view('admin.area', compact('area'));
    }

    // =========================================================================
    // 🚗 MANAJEMEN DATA KENDARAAN
    // =========================================================================

    public function crudKendaraan()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $kendaraan = DB::table('tb_kendaraan')->get();
        return view('admin.kendaraan', compact('kendaraan'));
    }

    public function hapusKendaraan($id)
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        DB::table('tb_transaksi')->where('id_kendaraan', $id)->delete();
        DB::table('tb_kendaraan')->where('id_kendaraan', $id)->delete();
        return redirect()->route('admin.kendaraan')->with('success', 'Data kendaraan berhasil dihapus!');
    }

    // =========================================================================
    // 📋 AUDIT LOG / REKAP AKTIVITAS SISTEM
    // =========================================================================

    public function aksesLog()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $logs = DB::table('tb_log_aktivitas')
            ->join('tb_user', 'tb_log_aktivitas.id_user', '=', 'tb_user.id_user')
            ->select('tb_log_aktivitas.*', 'tb_user.nama_lengkap', 'tb_user.role')
            ->orderBy('waktu_aktivitas', 'desc')
            ->get();
        return view('admin.log', compact('logs'));
    }

    public function hapusLog($id)
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        DB::table('tb_log_aktivitas')->where('id_log', $id)->delete();
        return redirect()->route('admin.log')->with('success', 'Log aktivitas berhasil dihapus!');
    }

    public function hapusSemuaLog()
    {
        if (!session()->has('role') || session('role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        DB::table('tb_log_aktivitas')->truncate();
        return redirect()->route('admin.log')->with('success', 'Semua log aktivitas berhasil dihapus!');
    }
}
