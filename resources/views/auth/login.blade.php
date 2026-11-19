<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Parkir XII</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Menghilangkan ikon mata bawaan browser Edge/IE agar tidak double */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        /* Mengatasi kotak berubah menjadi putih terang saat browser mengisi otomatis (autofill) */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0px 1000px rgba(30, 41, 59, 0.8) inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body style="background-image: linear-gradient(rgba(15, 23, 42, 0.45), rgba(15, 23, 42, 0.55)), url('{{ asset('images/parkir.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;" 
      class="flex items-center justify-center min-h-screen p-4 antialiased">

    <!-- Card Login Modern Glassmorphism -->
    <div class="bg-slate-950/85 backdrop-blur-2xl p-8 sm:p-10 rounded-3xl shadow-[0_0_45px_rgba(59,130,246,0.35),0_25px_60px_rgba(0,0,0,0.95)] w-full max-w-md border-2 border-blue-400/50 text-white relative overflow-hidden">
        <!-- Efek Cahaya Biru Halus di Sudut Atas -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Header -->
        <div class="text-center mb-8 flex flex-col items-center relative">
            <div class="w-14 h-14 bg-gradient-to-tr from-blue-600 to-blue-400 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 border border-white/25 mb-4">
                <span class="text-3xl font-black text-white tracking-tighter">P</span>
            </div>
    
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">E-Parkir XII</h2>
            <p class="text-slate-300 mt-1.5 text-sm">Silakan masuk untuk mengelola sistem parkir</p>
        </div>

        <!-- Notifikasi Error jika Gagal -->
        @if(session('error'))
            <div class="bg-red-500/20 backdrop-blur-md border border-red-400/40 p-3.5 mb-6 rounded-xl text-sm text-red-200 flex items-center gap-2.5">
                <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.proses') }}" method="POST" class="space-y-5 relative">
            @csrf
            
            <!-- Input Username -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input type="text" name="username" placeholder="Masukkan username" required
                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-white/10 !text-white placeholder-slate-400 border border-white/15 focus:bg-white/15 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
                </div>
            </div>

            <!-- Input Password -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>

                    <input type="password" id="passwordInput" name="password" placeholder="••••••••" required
                        class="w-full pl-11 pr-12 py-3 rounded-xl bg-white/10 text-white placeholder-slate-400 border border-white/15 focus:bg-white/15 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
                    
                    <!-- Tombol Mata SVG Interaktif -->
                    <button type="button" onclick="togglePassword()" title="Lihat/Sembunyikan Password"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center z-10 text-slate-200 hover:text-white cursor-pointer focus:outline-none">
                        <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tombol Lupa Kata Sandi -->
            <div class="flex justify-end">
                <a href="{{ route('password.request') }}" class="text-xs font-medium text-blue-300 hover:text-white transition">
                    Lupa Kata Sandi?
                </a>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" 
                class="w-full bg-blue-500/25 hover:bg-blue-500/40 backdrop-blur-md text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-950/40 border border-blue-400/50 transition transform active:scale-[0.98] cursor-pointer">
                Masuk ke Sistem
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-8 pt-5 border-t border-white/10 text-xs text-slate-400">
            &copy; 2026 Aplikasi Parkir SMK - XII Reguler
        </div>
    </div>

    <!-- Script Fungsi Tombol Intip -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
