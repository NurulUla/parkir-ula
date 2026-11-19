<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Mencegah error 'DB not found'

class PetugasDashboardController extends Controller
{
    // =========================================================================
    // 📊 HALAMAN UTAMA / DASHBOARD PETUGAS
    // =========================================================================
    public function index()
    {
        if (!session()->has('role') || session('role') !== 'petugas') {
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
    // 🚗 MANAJEMEN TRANSAKSI PARKIR
    // =========================================================================

    public function transaksi()
    {
        if (!session()->has('role') || session('role') !== 'petugas') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
        $tarif = DB::table('tb_tarif')->get();
        $area = DB::table('tb_area_parkir')->get();
        $transaksi_aktif = DB::table('tb_transaksi')
            ->join('tb_kendaraan', 'tb_transaksi.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->join('tb_area_parkir', 'tb_transaksi.id_area', '=', 'tb_area_parkir.id_area')
            ->where('tb_transaksi.status', 'masuk')
            ->select('tb_transaksi.*', 'tb_kendaraan.plat_nomor', 'tb_kendaraan.jenis_kendaraan', 'tb_area_parkir.nama_area')
            ->get();
        return view('petugas.transaksi', compact('tarif', 'area', 'transaksi_aktif'));
    }

    public function simpanTransaksiMasuk(Request $request)
    {
        if (!session()->has('role') || session('role') !== 'petugas') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'plat_nomor' => 'required',
            'id_tarif'   => 'required',
            'id_area'    => 'required',
            'warna'      => 'required',
            'pemilik'    => 'required'
        ]);

        $plat = strtoupper($request->plat_nomor);
        $kendaraan = DB::table('tb_kendaraan')->where('plat_nomor', $plat)->first();

        if ($kendaraan) {
            $masihMasuk = DB::table('tb_transaksi')
                ->where('id_kendaraan', $kendaraan->id_kendaraan)
                ->where('status', 'masuk')
                ->exists();

            if ($masihMasuk) {
                return redirect()->route('petugas.transaksi')->with('error', 'Kendaraan dengan plat ini tercatat masih berada di dalam area parkir!');
            }
            
            $id_kendaraan = $kendaraan->id_kendaraan;
        } else {
            $dataTarif = DB::table('tb_tarif')->where('id_tarif', $request->id_tarif)->first();
            $namaJenis = $dataTarif ? $dataTarif->jenis_kendaraan : 'lainnya';

            $id_kendaraan = DB::table('tb_kendaraan')->insertGetId([
                'plat_nomor'      => $plat,
                'warna'           => $request->warna,
                'pemilik'         => $request->pemilik, 
                'jenis_kendaraan' => $namaJenis 
            ]);
        }

        DB::table('tb_transaksi')->insert([
            'id_kendaraan' => $id_kendaraan,
            'id_tarif'     => $request->id_tarif,
            'id_area'      => $request->id_area,
            'waktu_masuk'  => now(),
            'status'       => 'masuk',
            'biaya_total'  => 0
        ]);

        DB::table('tb_area_parkir')
            ->where('id_area', $request->id_area)
            ->increment('terisi');

        return redirect()->route('petugas.transaksi')->with('success', 'Kendaraan berhasil masuk!');
    }

    public function hapusTransaksi($id)
    {
        if (!session()->has('role') || session('role') !== 'petugas') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        // ✨ DISESUAIKAN: Menggunakan kolom id_parkir untuk menghapus data transaksi
        DB::table('tb_transaksi')->where('id_parkir', $id)->delete();
        return redirect()->route('petugas.transaksi')->with('success', 'Data transaksi berhasil dihapus!');
    }

    // =========================================================================
    // 🧾 PROSES KELUAR & CETAK STRUK
    // =========================================================================

    public function prosesKeluar($id)
    {
        if (!session()->has('role') || session('role') !== 'petugas') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        // ✨ SUDAH DIPERBAIKI: Menggunakan id_parkir sesuai dengan struktur asli database Anda
        $transaksi = DB::table('tb_transaksi')
            ->join('tb_tarif', 'tb_transaksi.id_tarif', '=', 'tb_tarif.id_tarif')
            ->where('tb_transaksi.id_parkir', $id)
            ->first();

        if ($transaksi) {
            $waktu_masuk = new \DateTime($transaksi->waktu_masuk);
            $waktu_keluar = now();

            $selisih = $waktu_masuk->diff($waktu_keluar);
            $durasi_jam = $selisih->h + ($selisih->days * 24);

            if ($durasi_jam == 0) {
                $durasi_jam = 1;
            }

            $biaya_total = $durasi_jam * $transaksi->tarif_per_jam;

            // ✨ SUDAH DIPERBAIKI: Menggunakan id_parkir kembali
            DB::table('tb_transaksi')->where('id_parkir', $id)->update([
                'waktu_keluar' => $waktu_keluar,
                'durasi_jam' => $durasi_jam,
                'biaya_total' => $biaya_total,
                'status' => 'keluar'
            ]);

            DB::table('tb_area_parkir')
                ->where('id_area', $transaksi->id_area)
                ->decrement('terisi');

            return redirect()->route('petugas.transaksi')->with('success', 'Kendaraan berhasil keluar! Total Bayar: Rp ' . number_format($biaya_total, 0, ',', '.'));
        }

        return redirect()->route('petugas.transaksi')->with('error', 'Data transaksi tidak ditemukan.');
    }

    public function cetakStruk($id)
    {
        if (!session()->has('role')) {
            return redirect()->route('login');
        }

        $waktuKeluar = now();

        // 1. Ambil data awal transaksi
        $dataAwal = DB::table('tb_transaksi')->where('id_parkir', $id)->first();
        
        if (!$dataAwal) {
            return redirect()->route('petugas.transaksi')->with('error', 'Data tidak ditemukan');
        }

        // 2. LOGIKA HITUNG DURASI DETAIL (Jam dan Menit)
        $waktuMasuk = \Carbon\Carbon::parse($dataAwal->waktu_masuk);
        
        $totalMenit = $waktuMasuk->diffInMinutes($waktuKeluar);
        $durasiJam = floor($totalMenit / 60);
        $durasiMenit = $totalMenit % 60;

        // 3. LOGIKA HITUNG BIAYA (Contoh Tarif Rp 5.000 / Jam sesuai gambar Anda)
        $tarifPerJam = 5000;
        
        // Pembulatan durasi bayar: jika ada kelebihan menit, dihitung nambah 1 jam
        $jamBayar = $durasiJam;
        if ($durasiMenit > 0 || $jamBayar == 0) {
            $jamBayar += 1;
        }
        $biayaTotal = $jamBayar * $tarifPerJam;

        // 4. UPDATE DATA KE DATABASE
        DB::table('tb_transaksi')
            ->where('id_parkir', $id)
            ->update([
                'waktu_keluar' => $waktuKeluar,
                'biaya_total'  => $biayaTotal, // Sesuaikan nama kolom biaya di database Anda jika berbeda
                'status'       => 'keluar' 
            ]);

        // 5. AMBIL DATA LENGKAP GABUNGAN TABEL
        $transaksi = DB::table('tb_transaksi')
            ->join('tb_kendaraan', 'tb_transaksi.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->join('tb_area_parkir', 'tb_transaksi.id_area', '=', 'tb_area_parkir.id_area')
            ->where('tb_transaksi.id_parkir', $id)
            ->first();

        // Bungkus variabel durasi teks dan biaya untuk dilempar ke Blade
        $transaksi->durasi_teks = $durasiJam . " Jam " . $durasiMenit . " Menit";
        $transaksi->total_durasi_jam = $jamBayar . " Jam";
        $transaksi->biaya_hitung = $biayaTotal;
        $transaksi->tarif_per_jam = $tarifPerJam;

        return view('petugas.cetak', compact('transaksi'));
    }
}