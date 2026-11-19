<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log Aktivitas - E-Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-image: linear-gradient(rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.85)), url('{{ asset('images/parkir.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;" 
      class="font-sans antialiased text-white min-h-screen">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar Glassmorphism -->
        <nav class="bg-slate-950/60 backdrop-blur-xl border-b border-white/15 text-white shadow-lg sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 border border-white/15 px-4 py-2 rounded-xl text-xs font-bold transition duration-200 flex items-center gap-1.5">
                <span>⬅️</span> Kembali ke Dashboard
            </a>
            <h1 class="text-sm sm:text-base font-black uppercase tracking-wider text-white">Audit Log Aktivitas Sistem</h1>
            <span class="text-xs bg-blue-500/20 border border-blue-400/30 text-blue-300 px-3 py-1.5 rounded-lg font-bold uppercase">{{ session('role') }}</span>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8 max-w-6xl mx-auto w-full">
            
            <div class="bg-slate-900/50 backdrop-blur-xl p-6 md:p-8 rounded-3xl shadow-2xl border border-white/15 relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-44 h-44 bg-violet-500/15 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5 relative">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2"><span>📜</span> Jejak Aktivitas Pengguna & Petugas</h3>

                    @if(count($logs) > 0)
                        <form action="{{ route('admin.log.hapusSemua') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus SEMUA log aktivitas? Tindakan ini tidak bisa dibatalkan!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-rose-500/20 hover:bg-rose-500/40 backdrop-blur-md border border-rose-400/40 text-rose-200 hover:text-white font-bold px-4 py-2 rounded-xl text-xs shadow-lg shadow-rose-950/20 transition cursor-pointer">
                                🗑️ Hapus Semua Log
                            </button>
                        </form>
                    @endif
                </div>

                <div class="overflow-x-auto rounded-2xl border border-white/10 relative">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/15 text-xs font-bold uppercase tracking-wider text-slate-300 bg-white/5">
                                <th class="py-3.5 px-4">Waktu Kejadian</th>
                                <th class="py-3.5 px-4">Nama Pelaku</th>
                                <th class="py-3.5 px-4">Detail Aktivitas</th>
                                <th class="py-3.5 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/10 font-medium text-slate-200">
                            @forelse($logs as $log)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="py-4 px-4 text-slate-300 text-xs whitespace-nowrap">
                                        📅 {{ date('d M Y, H:i:s', strtotime($log->waktu_aktivitas)) }} WIB
                                    </td>
                                    <td class="py-4 px-4 text-white font-bold">
                                        <div>{{ $log->nama_lengkap }}</div>
                                        
                                        <!-- Badge Keterangan Peran/Role secara Dinamis -->
                                        @if($log->role == 'admin')
                                            <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-rose-500/20 text-rose-300 border border-rose-400/30">
                                                🛡️ Admin
                                            </span>
                                        @elseif($log->role == 'petugas')
                                            <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-blue-500/20 text-blue-300 border border-blue-400/30">
                                                💼 Petugas
                                            </span>
                                        @elseif($log->role == 'owner')
                                            <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-amber-500/20 text-amber-300 border border-amber-400/30">
                                                👑 Owner
                                            </span>
                                        @else
                                            <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-white/10 text-slate-300 border border-white/15">
                                                ❓ Pengguna
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-block px-3 py-1 rounded-lg text-xs bg-white/10 text-slate-200 border border-white/15 font-normal">
                                            {{ $log->aktivitas }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <form action="{{ route('admin.log.hapus', $log->id_log) }}" method="POST" onsubmit="return confirm('Hapus riwayat log aktivitas ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500/20 hover:bg-rose-500/40 backdrop-blur-md border border-rose-400/40 text-rose-200 hover:text-white font-bold px-3.5 py-1.5 rounded-xl text-xs shadow-sm transition cursor-pointer">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-slate-400 font-normal">📭 Belum ada riwayat aktivitas yang tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <footer class="w-full text-center py-6 text-xs text-slate-400 bg-slate-950/60 backdrop-blur-md border-t border-white/10 mt-10">
            &copy; 2026 Aplikasi E-Parkir Digital — Project RPL XII Reguler
        </footer>
    </div>

</body>
</html>
