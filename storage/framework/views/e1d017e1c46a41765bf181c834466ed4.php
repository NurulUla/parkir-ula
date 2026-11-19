<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utama - E-Parkir</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body style="background-image: linear-gradient(rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.85)), url('<?php echo e(asset('images/parkir.jpg')); ?>'); background-size: cover; background-position: center; background-attachment: fixed;" class="font-sans antialiased text-white min-h-screen">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-slate-950/60 backdrop-blur-xl border-b border-white/15 text-white shadow-lg sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🅿️</span>
                <h1 class="text-xl font-black tracking-wider uppercase">Sistem E-Parkir XII</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex flex-col text-right hidden sm:flex">
                    <span class="font-bold text-sm"><?php echo e(session('nama')); ?></span>
                    <span class="text-xs text-blue-200 font-semibold tracking-wide uppercase"><?php echo e(session('role')); ?></span>
                </div>
                <div class="h-8 w-px bg-blue-400 hidden sm:block"></div>
                <a href="<?php echo e(route('logout')); ?>" class="bg-rose-500/20 hover:bg-rose-500/40 backdrop-blur-md border border-rose-400/40 text-rose-200 hover:text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-rose-950/20 transition duration-200 transform active:scale-95">Keluar</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-10 max-w-6xl mx-auto w-full">
            <div class="bg-slate-900/50 backdrop-blur-xl p-6 md:p-8 rounded-3xl shadow-2xl border border-white/15 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Selamat Datang Kembali, <?php echo e(session('nama')); ?>! 👋</h2>
                    <p class="text-slate-300 mt-1">Status hak akses Anda: <span class="text-blue-600 font-bold uppercase"><?php echo e(session('role')); ?></span>. Kelola sistem parkir secara real-time dengan menu di bawah ini.</p>
                </div>
                <div class="text-sm font-semibold text-slate-200 bg-white/10 border border-white/15 px-4 py-2 rounded-xl">📅 <?php echo e(date('d M Y')); ?></div>
            </div>

            <!-- Widgets BARU -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                <!-- Kotak 1: Kendaraan Aktif -->
                <div class="bg-blue-500/15 backdrop-blur-lg p-6 rounded-2xl border border-blue-400/30 shadow-lg hover:bg-blue-500/20 transition">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-bold text-blue-300 uppercase">Kendaraan Aktif</span>
                        <span class="text-2xl">🚗</span>
                    </div>
                    <div class="text-3xl font-black text-white"><?php echo e($kendaraan_aktif); ?> <span class="text-sm font-normal text-blue-200">Unit</span></div>
                </div>

                <!-- Kotak 2: Slot Tersedia -->
                <div class="bg-emerald-500/15 backdrop-blur-lg p-6 rounded-2xl border border-emerald-400/30 shadow-lg hover:bg-emerald-500/20 transition">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-bold text-emerald-300 uppercase">Slot Tersedia</span>
                        <span class="text-2xl">🔲</span>
                    </div>
                    <div class="text-3xl font-black text-white"><?php echo e($slot_tersedia); ?> <span class="text-sm font-normal text-emerald-200">Slot</span></div>
                </div>

                <!-- Kotak 3: Pendapatan Hari Ini -->
                <div class="bg-violet-500/15 backdrop-blur-lg p-6 rounded-2xl border border-violet-400/30 shadow-lg hover:bg-violet-500/20 transition">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-bold text-violet-300 uppercase">Pendapatan Hari Ini</span>
                        <span class="text-2xl">💰</span>
                    </div>
                    <div class="text-3xl font-black text-white">Rp <?php echo e(number_format($pendapatan_hari_ini, 0, ',', '.')); ?></div>
                </div>
            </div>

            <!-- Menus -->
            <div class="space-y-10">
                <?php if(session('role') == 'admin'): ?>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-300 mb-4">🛠️ Otoritas & Manajemen Admin</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <a href="<?php echo e(route('admin.user')); ?>" class="group bg-slate-900/50 backdrop-blur-lg p-5 rounded-2xl border border-white/15 shadow-lg hover:bg-slate-800/70 hover:border-blue-400/50 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-blue-500/20 text-blue-300 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition text-xl">👥</div>
                            <div>
                                <h4 class="font-bold text-white group-hover:text-blue-300 transition">CRUD User</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Kelola data login petugas & hak akses.</p>
                            </div>
                        </a>

                        <a href="<?php echo e(route('admin.tarif')); ?>" class="group bg-slate-900/50 backdrop-blur-lg p-5 rounded-2xl border border-white/15 shadow-lg hover:bg-slate-800/70 hover:border-emerald-400/50 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-emerald-500/20 text-emerald-300 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition text-xl">💵</div>
                            <div>
                                <h4 class="font-bold text-white group-hover:text-emerald-300 transition">Tarif Parkir</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Atur tarif per jam motor / mobil.</p>
                            </div>
                        </a>

                        <a href="<?php echo e(route('admin.area')); ?>" class="group bg-slate-900/50 backdrop-blur-lg p-5 rounded-2xl border border-white/15 shadow-lg hover:bg-slate-800/70 hover:border-amber-400/50 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-amber-500/20 text-amber-300 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition text-xl">🗺️</div>
                            <div>
                                <h4 class="font-bold text-white group-hover:text-amber-300 transition">Area Parkir</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Pantau kapasitas gedung / slot parkir.</p>
                            </div>
                        </a>

                        <a href="<?php echo e(route('admin.kendaraan')); ?>" class="group bg-slate-900/50 backdrop-blur-lg p-5 rounded-2xl border border-white/15 shadow-lg hover:bg-slate-800/70 hover:border-indigo-400/50 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-indigo-500/20 text-indigo-300 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition text-xl">🚘</div>
                            <div>
                                <h4 class="font-bold text-white group-hover:text-indigo-300 transition">Data Kendaraan</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Kelola plat nomor & data pemilik resmi.</p>
                            </div>
                        </a>

                        <a href="<?php echo e(route('admin.log')); ?>" class="group bg-slate-900/50 backdrop-blur-lg p-5 rounded-2xl border border-white/15 shadow-lg hover:bg-slate-800/70 hover:border-violet-400/50 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-violet-500/20 text-violet-300 rounded-xl group-hover:bg-violet-600 group-hover:text-white transition text-xl">📜</div>
                            <div>
                                <h4 class="font-bold text-white group-hover:text-violet-300 transition">Akses Log Aktivitas</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Audit jejak aktivitas sistem petugas.</p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(session('role') == 'petugas'): ?>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4">🚗 Operasional Lapangan / Petugas</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <a href="<?php echo e(route('petugas.transaksi')); ?>" class="group bg-slate-900/50 backdrop-blur-lg p-5 rounded-2xl border border-amber-400/30 shadow-lg hover:bg-slate-800/70 hover:border-amber-400/70 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-amber-500/20 text-amber-300 border border-amber-400/20 rounded-xl group-hover:bg-amber-500 group-hover:text-white transition text-xl">🎫</div>
                            <div>
                                <h4 class="font-bold text-white group-hover:text-amber-300 transition">Input Transaksi Parkir</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Catat masuk & keluar / cetak karcis.</p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(session('role') == 'owner'): ?>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-300 mb-4">📊 Laporan Eksekutif / Owner</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <a href="<?php echo e(route('owner.rekap')); ?>" class="group bg-slate-900/50 backdrop-blur-lg p-5 rounded-2xl border border-white/15 shadow-lg hover:bg-slate-800/70 hover:border-purple-400/50 transition duration-300 flex items-center gap-4">
                            <div class="p-3 bg-purple-500/20 text-purple-300 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition text-xl">📊</div>
                            <div>
                                <h4 class="font-bold text-white group-hover:text-purple-300 transition">Rekap & Laporan</h4>
                                <p class="text-xs text-slate-300 mt-0.5">Analisis pendapatan sesuai rentang waktu.</p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>

        <?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</body>
</html><?php /**PATH C:\ula-xii\web-xii\parkir-xii-reguler\resources\views/utama.blade.php ENDPATH**/ ?>