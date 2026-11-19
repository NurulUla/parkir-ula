<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarif Parkir - E-Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-image: linear-gradient(rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.85)), url('{{ asset('images/parkir.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;" 
      class="font-sans antialiased text-white min-h-screen">

    <div class="min-h-screen flex flex-col">
        <!-- 🖥️ Top Navbar Glassmorphism -->
        <nav class="bg-slate-950/60 backdrop-blur-xl border-b border-white/15 text-white shadow-lg sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 border border-white/15 px-4 py-2 rounded-xl text-xs font-bold transition duration-200 flex items-center gap-1.5">
                <span>⬅️</span> Kembali ke Dashboard
            </a>
            <h1 class="text-sm sm:text-base font-black uppercase tracking-wider text-white">Manajemen Tarif Parkir</h1>
            <span class="text-xs bg-blue-500/20 border border-blue-400/30 text-blue-300 px-3 py-1.5 rounded-lg font-bold uppercase">{{ session('role') }}</span>
        </nav>

        <!-- 📊 Main Content Area -->
        <main class="flex-1 p-6 md:p-8 max-w-5xl mx-auto w-full">
            
            <div class="bg-slate-900/50 backdrop-blur-xl p-6 md:p-8 rounded-3xl shadow-2xl border border-white/15 relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-44 h-44 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>

                <h3 class="text-lg font-bold text-white mb-5 flex items-center gap-2 relative">
                    <span>💵</span> Daftar Tarif Per Jenis Kendaraan
                </h3>
                
                <div class="overflow-x-auto rounded-2xl border border-white/10 relative">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/15 text-xs font-bold uppercase tracking-wider text-slate-300 bg-white/5">
                                <th class="py-3.5 px-4">ID</th>
                                <th class="py-3.5 px-4">Jenis Kendaraan</th>
                                <th class="py-3.5 px-4">Tarif Per Jam</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/10 font-medium text-slate-200">
                            @forelse($tarif as $t)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="py-4 px-4 text-slate-400 text-xs">#{{ $t->id_tarif }}</td>
                                    <td class="py-4 px-4 font-black text-white tracking-wide uppercase">{{ $t->jenis_kendaraan }}</td>
                                    <td class="py-4 px-4 font-bold text-emerald-400">Rp {{ number_format($t->tarif_per_jam, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-12 text-center text-slate-400 font-normal">
                                        📭 Belum ada data tarif parkir.
                                    </td>
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
