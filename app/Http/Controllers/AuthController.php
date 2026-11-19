<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Login
    public function showLogin() {
        return view('auth.login');
    }

    // 2. Memproses Logika Login
    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari user berdasarkan username dan status aktif saja
        $user = DB::table('tb_user')
            ->where('username', $request->username)
            ->where('status_aktif', 1)
            ->first();

        if ($user) {
            $isPasswordValid = false;

            // 🔍 Cek Cara 1: Jika password di DB adalah Bcrypt Hash bawaan Laravel
            if (str_starts_with($user->password, '$2y$') || str_starts_with($user->password, '$2a$')) {
                $isPasswordValid = Hash::check($request->password, $user->password);
            } else {
                // 🔍 Cek Cara 2: Jika password di DB masih teks polos/biasa (Solusi Error Anda)
                $isPasswordValid = ($request->password === $user->password);
            }

            // Jika password cocok (baik hash maupun plain text)
            if ($isPasswordValid) {
                // Simpan data ke session
                session([
                    'id_user' => $user->id_user, 
                    'role' => $user->role, 
                    'nama' => $user->nama_lengkap
                ]);
                
                // Catat log aktivitas login
                DB::table('tb_log_aktivitas')->insert([
                    'id_user' => $user->id_user,
                    'aktivitas' => 'User berhasil login ke sistem',
                    'waktu_aktivitas' => now()
                ]);

                return redirect()->route('dashboard');
            }
        }

        // Jika user tidak ditemukan atau password salah
        return back()->with('error', 'Username atau Password salah!');
    }

    // 3. Memproses Logout
    public function logout() {
        if (session()->has('id_user')) {
            DB::table('tb_log_aktivitas')->insert([
                'id_user' => session('id_user'),
                'aktivitas' => 'User berhasil logout dari sistem',
                'waktu_aktivitas' => now()
            ]);
        }

        session()->flush();
        return redirect()->route('login')->with('error', 'Anda telah keluar dari sistem.');
    }
}
