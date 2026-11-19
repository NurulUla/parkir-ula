<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - E-Parkir</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body style="background-image: linear-gradient(rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.85)), url('<?php echo e(asset('images/parkir.jpg')); ?>'); background-size: cover; background-position: center; background-attachment: fixed;" 
      class="font-sans antialiased text-white min-h-screen">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar Glassmorphism -->
        <nav class="bg-slate-950/60 backdrop-blur-xl border-b border-white/15 text-white shadow-lg sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
            <a href="<?php echo e(route('dashboard')); ?>" class="bg-white/10 hover:bg-white/20 border border-white/15 px-4 py-2 rounded-xl text-xs font-bold transition duration-200 flex items-center gap-1.5">
                <span>⬅️</span> Kembali ke Dashboard
            </a>
            <h1 class="text-sm sm:text-base font-black uppercase tracking-wider text-white">Laporan Rekapitulasi Pendapatan</h1>
            <span class="text-xs bg-amber-500/20 border border-amber-400/30 text-amber-300 px-3 py-1.5 rounded-lg font-bold uppercase"><?php echo e(session('role')); ?></span>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8 max-w-5xl mx-auto w-full">
            
            <!-- Widget Total Pendapatan -->
            <div class="bg-gradient-to-r from-blue-600/30 to-indigo-600/30 backdrop-blur-xl p-6 md:p-8 rounded-3xl border border-blue-400/30 text-white shadow-2xl mb-8 flex justify-between items-center relative overflow-hidden">
                <div class="absolute -right-12 -top-12 w-40 h-40 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-blue-300">Total Uang Parkir Masuk (Selesai)</h3>
                    <div class="text-3xl sm:text-4xl font-black mt-1.5 text-white">
                        Rp <?php echo e(number_format($laporan->sum('biaya_total'), 0, ',', '.')); ?>

                    </div>
                </div>
                <span class="text-4xl sm:text-5xl relative">💰</span>
            </div>

            <!-- Tabel Rekap Transaksi -->
            <div class="bg-slate-900/50 backdrop-blur-xl p-6 md:p-8 rounded-3xl shadow-2xl border border-white/15">
                <h3 class="text-lg font-bold text-white mb-5 flex items-center gap-2"><span>📊</span> Riwayat Kendaraan Selesai Parkir</h3>
                <div class="overflow-x-auto rounded-2xl border border-white/10">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/15 text-xs font-bold uppercase tracking-wider text-slate-300 bg-white/5">
                                <th class="py-3.5 px-4">Plat Nomor</th>
                                <th class="py-3.5 px-4">Jenis</th>
                                <th class="py-3.5 px-4">Durasi</th>
                                <th class="py-3.5 px-4 text-right">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/10 font-medium text-slate-200">
                            <?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-white/5 transition">
                                    <td class="py-4 px-4 font-black text-white tracking-wider uppercase"><?php echo e($l->plat_nomor); ?></td>
                                    <td class="py-4 px-4">
                                        <span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase bg-blue-500/20 text-blue-300 border border-blue-400/30">
                                            <?php echo e($l->jenis_kendaraan); ?>

                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-slate-300 text-xs"><?php echo e($l->durasi_jam); ?> Jam</td>
                                    <td class="py-4 px-4 text-right font-bold text-emerald-400">Rp <?php echo e(number_format($l->biaya_total, 0, ',', '.')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="py-12 px-4 text-center text-slate-400 text-xs italic">
                                        📭 Belum ada data rekapitulasi pendapatan kendaraan selesai parkir.
                                    </td>
                                </tr>
                            <?php endif; ?>
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
<?php /**PATH C:\ula-xii\web-xii\parkir-xii-reguler\resources\views/owner/rekap.blade.php ENDPATH**/ ?>