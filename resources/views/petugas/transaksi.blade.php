<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Parkir - E-Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    /* Mengatasi kotak berubah menjadi putih terang saat browser mengisi otomatis (autofill) */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px rgba(30, 41, 59, 0.85) inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* Memaksa popup dropdown bawaan Windows/Chrome memakai tema gelap agar teks terbaca jelas */
    select {
        color-scheme: dark;
    }
    select option {
        background-color: #0f172a !important;
        color: #ffffff !important;
    }
</style>
</head>
<body style="background-image: linear-gradient(rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.85)), url('{{ asset('images/parkir.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;" 
      class="font-sans antialiased text-white min-h-screen">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-slate-950/60 backdrop-blur-xl border-b border-white/15 text-white shadow-lg sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 border border-white/15 px-4 py-2 rounded-xl text-xs font-bold transition">
                ⬅️ Kembali ke Dashboard
            </a>
            <h1 class="text-md font-black uppercase tracking-wider">Operasional Transaksi Parkir</h1>
            <span class="text-xs bg-blue-500/20 border border-blue-400/30 text-blue-300 px-3 py-1 rounded-lg font-bold uppercase">{{ session('role') }}</span>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 max-w-6xl mx-auto w-full grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Form Input -->
            <div class="bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/15 h-fit">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2"><span>➕</span> Catat Kendaraan Masuk</h3>
                
                @if(session('success'))
                    <div class="bg-emerald-500/20 backdrop-blur-md border-l-4 border-emerald-400 p-3 mb-4 rounded-r-lg text-xs text-emerald-200 font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-rose-50 border-l-4 border-rose-500 p-3 mb-4 rounded-r-lg text-xs text-rose-700 font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('petugas.transaksi.simpan') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Nomor Plat Kendaraan</label>
                        <input type="text" name="plat_nomor" placeholder="Contoh: N 1234 AB" required
                            class="w-full px-4 py-2.5 rounded-xl bg-white/10 text-white placeholder-slate-400 border border-white/15 uppercase font-bold tracking-wide text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Jenis Kendaraan</label>
                        <select name="id_tarif" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @foreach($tarif as $t)
                                <option value="{{ $t->id_tarif }}">{{ ucfirst($t->jenis_kendaraan) }} (Rp {{ number_format($t->tarif_per_jam, 0, ',', '.') }}/jam)</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Area / Slot Parkir</label>
                        <select name="id_area" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @foreach($area as $a)
                                <option value="{{ $a->id_area }}">{{ $a->nama_area }} (Slot: {{ $a->kapasitas }})</option>
                            @endforeach
                        </select>
                    </div>                  
                    <!-- Penambahan Input Warna Kendaraan -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Warna Kendaraan</label>
                        <input type="text" name="warna" placeholder="Contoh: Hitam, Putih, Merah" required
                            class="w-full px-4 py-2.5 rounded-xl bg-white/10 text-white placeholder-slate-400 border border-white/15 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <!-- Penambahan Input Nama Pemilik -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1">Nama Pemilik</label>
                        <input type="text" name="pemilik" placeholder="Masukkan nama pemilik kendaraan" required
                            class="w-full px-4 py-2.5 rounded-xl bg-white/10 text-white placeholder-slate-400 border border-white/15 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <button type="submit" class="w-full bg-orange-500/25 hover:bg-orange-500/40 backdrop-blur-md border border-orange-400/50 text-orange-200 hover:text-white font-bold py-3 rounded-xl shadow-lg shadow-orange-950/30 text-sm transition cursor-pointer">
                        🖨️ Cetak Karcis Masuk
                    </button>
                </form>
            </div>

            <!-- Tabel Data -->
            <div class="lg:col-span-2 bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/15">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2"><span>🚘</span> Kendaraan Aktif di Dalam Area</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/15 text-slate-300 bg-white/5">
                                <th class="py-3 px-4">Plat Nomor</th>
                                <th class="py-3 px-4">Jenis</th>
                                <th class="py-3 px-4">Lokasi Area</th>
                                <th class="py-3 px-4">Waktu Masuk</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/10 font-medium">
                            @forelse($transaksi_aktif as $tr)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="py-3.5 px-4 font-black text-white tracking-wide uppercase">{{ $tr->plat_nomor }}</td>
                                    <td class="py-3.5 px-4"><span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase bg-blue-500/20 text-blue-300 border border-blue-400/30">{{ $tr->jenis_kendaraan }}</span></td>
                                    <td class="py-3.5 px-4 text-slate-300 text-xs">{{ $tr->nama_area }}</td>
                                    <td class="py-3.5 px-4 text-slate-300 text-xs">{{ date('d M, H:i', strtotime($tr->waktu_masuk)) }} WIB</td>
                                    <td class="py-3.5 px-4 flex flex-col gap-1 items-center justify-center">
                                        <!-- Perbaikan Sempurna: Mengarahkan href ke rute keluar bawaan ID transaksi asli -->
                                        <a href="{{ route('petugas.cetak', $tr->id_parkir) }}" 
                                        onclick="return confirm('Proses pembayaran dan keluarkan kendaraan ini?')"
                                        class="bg-emerald-500/20 hover:bg-emerald-500/40 backdrop-blur-md border border-emerald-400/40 text-emerald-200 hover:text-white font-bold px-3 py-1.5 rounded-xl text-xs shadow-sm transition w-32 text-center">
                                            ✅ Keluar & Bayar
                                        </a>

                                        <form action="{{ route('petugas.transaksi.hapus', $tr->id_parkir) }}" method="POST" onsubmit="return confirm('Hapus data kendaraan ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500/20 hover:bg-rose-500/40 backdrop-blur-md border border-rose-400/40 text-rose-200 hover:text-white font-bold px-3 py-1.5 rounded-xl text-xs shadow-sm transition w-32 cursor-pointer">
                                                🗑️ Hapus Data
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400 font-normal">📭 Tidak ada kendaraan di dalam area parkir.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
