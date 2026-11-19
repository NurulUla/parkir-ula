<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - E-Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-image: linear-gradient(rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.85)), url('{{ asset('images/parkir.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;" class="font-sans antialiased text-white min-h-screen">

    <div class="min-h-screen flex flex-col">
        <!-- 🖥️ Top Navbar -->
        <nav class="bg-slate-950/60 backdrop-blur-xl border-b border-white/15 text-white shadow-lg sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white px-4 py-2 rounded-xl text-xs font-bold transition duration-200">
                    ⬅️ Kembali ke Dashboard
                </a>
            </div>
            <h1 class="text-md font-black uppercase tracking-wider">Manajemen Pengguna (User)</h1>
                <span class="text-xs bg-blue-500/20 border border-blue-400/35 text-blue-300 px-3 py-1.5 rounded-lg font-bold uppercase">{{ session('role') }}</span>
        </nav>

        <!-- 📊 Main Content Area -->
        <main class="flex-1 p-6 max-w-6xl mx-auto w-full grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- 📥 Form Tambah User -->
            <div class="bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/15 h-fit">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2"><span>➕</span> Tambah User</h3>
                
                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-3 mb-4 rounded-r-lg text-xs text-emerald-700 font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-rose-50 border-l-4 border-rose-500 p-3 mb-4 rounded-r-lg text-xs text-rose-700 font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Notifikasi Error Validasi -->
                @if($errors->any())
                    <div class="bg-rose-50 border-l-4 border-rose-500 p-3 mb-4 rounded-r-lg text-xs text-rose-700 font-medium">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.user.simpan') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama Petugas" required class="w-full px-4 py-2.5 rounded-xl border bg-white/10 text-white placeholder-slate-400 border border-white/15 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Username Login</label>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="petugas_budi" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 text-white placeholder-slate-400 border border-white/15 text-sm lowercase focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Password</label>
                        <input type="password" name="password" placeholder="••••••••" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 text-white placeholder-slate-400 border border-white/15 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-300 mb-1">Hak Akses (Role)</label>
                        <select name="role" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800/90 text-white border border-white/15 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas Lapangan</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner / Pemilik</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-500/25 hover:bg-blue-500/40 backdrop-blur-md border border-blue-400/50 text-white font-bold py-3 rounded-xl text-sm shadow-lg shadow-blue-950/30 transition cursor-pointer">💾 Simpan User</button>
                </form>
            </div>

            <!-- 👥 Tabel Daftar User -->
            <div class="lg:col-span-2 bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl shadow-2xl border border-white/15">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2"><span>👥</span> Pengguna Terdaftar</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/15 text-slate-300 bg-white/5">
                                <th class="py-3 px-4">Nama Lengkap</th>
                                <th class="py-3 px-4">Username</th>
                                <th class="py-3 px-4">Role</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/10 font-medium">
                            @foreach($users as $u)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="py-3.5 px-4 font-bold text-white">{{ $u->nama_lengkap }}</td>
                                    <td class="py-3.5 px-4 text-slate-300 text-xs">@<span>{{ $u->username }}</span></td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase border 
                                            @if($u->role == 'admin') bg-blue-500/20 text-blue-300 border-blue-400/30 
                                            @elseif($u->role == 'owner') bg-purple-500/20 text-purple-300 border-purple-400/30 
                                            @else bg-amber-500/20 text-amber-300 border-amber-400/30 @endif">
                                            {{ $u->role }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">Aktif</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <!-- Tombol Hapus User Akun -->
                                        <form action="{{ route('admin.user.hapus', $u->id_user) }}" method="POST" onsubmit="return confirm('Hapus akun ini permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500/20 hover:bg-rose-500/40 backdrop-blur-md border border-rose-400/40 text-rose-200 hover:text-white font-bold px-3 py-1.5 rounded-lg text-xs shadow-sm transition cursor-pointer">
                                                🗑️ Hapus
                                            </button>                                
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>