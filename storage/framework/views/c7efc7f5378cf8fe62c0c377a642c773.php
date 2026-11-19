<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kendaraan - E-Parkir</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body style="background-image: linear-gradient(rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.85)), url('<?php echo e(asset('images/parkir.jpg')); ?>'); background-size: cover; background-position: center; background-attachment: fixed;" 
      class="font-sans antialiased text-white min-h-screen">

    <div class="min-h-screen flex flex-col">
        <!-- 🖥️ Top Navbar Glassmorphism -->
        <nav class="bg-slate-950/60 backdrop-blur-xl border-b border-white/15 text-white shadow-lg sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
            <a href="<?php echo e(route('dashboard')); ?>" class="bg-white/10 hover:bg-white/20 border border-white/15 px-4 py-2 rounded-xl text-xs font-bold transition duration-200 flex items-center gap-1.5">
                <span>⬅️</span> Kembali ke Dashboard
            </a>
            <h1 class="text-sm sm:text-base font-black uppercase tracking-wider text-white">Manajemen Data Kendaraan</h1>
            <span class="text-xs bg-blue-500/20 border border-blue-400/30 text-blue-300 px-3 py-1.5 rounded-lg font-bold uppercase"><?php echo e(session('role')); ?></span>
        </nav>

        <!-- 📊 Main Content Area -->
        <main class="flex-1 p-6 md:p-8 max-w-5xl mx-auto w-full">
            
            <div class="bg-slate-900/50 backdrop-blur-xl p-6 md:p-8 rounded-3xl shadow-2xl border border-white/15 relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-44 h-44 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

                <h3 class="text-lg font-bold text-white mb-5 flex items-center gap-2 relative">
                    <span>🚘</span> Daftar Kendaraan Terdaftar Dalam Sistem
                </h3>

                <?php if(session('success')): ?>
                    <div class="bg-emerald-500/20 backdrop-blur-md border-l-4 border-emerald-400 p-3.5 mb-5 rounded-r-xl text-xs text-emerald-200 font-medium">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                
                <div class="overflow-x-auto rounded-2xl border border-white/10 relative">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/15 text-xs font-bold uppercase tracking-wider text-slate-300 bg-white/5">
                                <th class="py-3.5 px-4">ID</th>
                                <th class="py-3.5 px-4">Plat Nomor</th>
                                <th class="py-3.5 px-4">Jenis Kendaraan</th>
                                <th class="py-3.5 px-4">Warna</th>
                                <th class="py-3.5 px-4">Nama Pemilik</th>
                                <th class="py-3.5 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/10 font-medium text-slate-200">
                            <?php $__empty_1 = true; $__currentLoopData = $kendaraan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-white/5 transition">
                                    <td class="py-4 px-4 text-slate-400 text-xs">#<?php echo e($k->id_kendaraan); ?></td>
                                    <td class="py-4 px-4 font-black text-white tracking-wider uppercase"><?php echo e($k->plat_nomor); ?></td>
                                    <td class="py-4 px-4">
                                        <!-- Badge Jenis Kendaraan -->
                                        <span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase border 
                                            <?php echo e(strtolower($k->jenis_kendaraan) == 'mobil' ? 'bg-blue-500/20 text-blue-300 border-blue-400/30' : 'bg-amber-500/20 text-amber-300 border-amber-400/30'); ?>">
                                            <?php echo e($k->jenis_kendaraan ?? 'Tidak Diketahui'); ?>

                                        </span>
                                    </td>

                                    <td class="py-4 px-4 text-xs text-slate-300"><?php echo e($k->warna ?? '-'); ?></td>
                                    <td class="py-4 px-4 font-semibold text-white"><?php echo e($k->pemilik ?? '-'); ?></td>
                                    <td class="py-4 px-4 text-center">
                                        <form action="<?php echo e(route('admin.kendaraan.hapus', $k->id_kendaraan)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data induk kendaraan ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="bg-rose-500/20 hover:bg-rose-500/40 backdrop-blur-md border border-rose-400/40 text-rose-200 hover:text-white font-bold px-3.5 py-1.5 rounded-xl text-xs shadow-sm transition cursor-pointer">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400 font-normal">
                                        📭 Belum ada data kendaraan terdaftar.
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
</html><?php /**PATH C:\ula-xii\web-xii\parkir-xii-reguler\resources\views/admin/kendaraan.blade.php ENDPATH**/ ?>