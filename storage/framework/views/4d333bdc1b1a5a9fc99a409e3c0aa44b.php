<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - E-Parkir XII</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body style="background-image: linear-gradient(rgba(15, 23, 42, 0.45), rgba(15, 23, 42, 0.55)), url('<?php echo e(asset('images/parkir.jpg')); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;" 
      class="flex items-center justify-center min-h-screen p-4 antialiased">

    <!-- Card Glassmorphism -->
    <div class="bg-slate-950/60 backdrop-blur-xl p-8 sm:p-10 rounded-3xl shadow-[0_25px_60px_rgba(0,0,0,0.75)] w-full max-w-md border border-white/25 text-white text-center relative overflow-hidden">
        
        <!-- Efek Cahaya Biru Halus -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Ikon Kunci -->
        <div class="w-16 h-16 bg-amber-500/20 border border-amber-400/35 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg relative">
            <span class="text-3xl select-none">🔑</span>
        </div>

        <!-- Judul & Keterangan -->
        <h2 class="text-2xl font-bold tracking-tight text-white mb-3 relative">Lupa Kata Sandi?</h2>
        <p class="text-slate-300 text-sm leading-relaxed mb-7 relative">
            Untuk menjaga keamanan data sistem parkir, fitur reset mandiri dinonaktifkan. Silakan hubungi <strong class="text-white font-semibold">Administrator IT / Guru Pembimbing</strong> untuk melakukan reset password akun Anda.
        </p>

        <!-- Tombol Kembali ke Login (Kaca Biru Transparan) -->
        <a href="<?php echo e(route('login')); ?>" 
           class="block w-full bg-blue-500/25 hover:bg-blue-500/40 backdrop-blur-md border border-blue-400/50 text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-950/40 transition transform active:scale-[0.98] relative">
            ⬅️ Kembali ke Login
        </a>

        <!-- Footer -->
        <div class="text-center mt-8 pt-5 border-t border-white/10 text-xs text-slate-400 relative">
            &copy; 2026 Aplikasi Parkir SMK - XII Reguler
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\ula-xii\web-xii\parkir-xii-reguler\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>