<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar akun Nexora - Student Productivity Ecosystem. Kelola tugas, jadwal belajar, dan catatan dalam satu platform terintegrasi.">
    <title>Daftar Student | Nexora</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgba(48, 10, 36, 1) 0%, rgba(26, 8, 38, 1) 45%, rgba(10, 4, 20, 1) 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .font-title {
            font-family: 'Outfit', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 
                        0 0 40px rgba(95, 27, 81, 0.15);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-input:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(168, 85, 247, 0.6);
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.25);
            outline: none;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #7c3aed 0%, #4a154b 50%, #300a24 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.5), 
                        0 0 15px rgba(74, 21, 75, 0.4);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .btn-gradient:active {
            transform: translateY(1px);
        }

        .glow-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.15) 0%, rgba(0,0,0,0) 70%);
            position: absolute;
            top: -10%;
            left: -10%;
            z-index: 0;
            pointer-events: none;
        }

        .glow-2 {
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(74, 21, 75, 0.2) 0%, rgba(0,0,0,0) 70%);
            position: absolute;
            bottom: -10%;
            right: -10%;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 relative min-h-screen">

    <div class="glow-1"></div>
    <div class="glow-2"></div>

    <div class="w-full max-w-lg z-10 my-8">
        
        <div class="text-center mb-8 animate-fade-in">
            <h1 class="font-title text-4xl font-extrabold tracking-wider bg-gradient-to-r from-purple-400 via-pink-400 to-purple-300 bg-clip-text text-transparent drop-shadow-sm">
                NEXORA
            </h1>
            <p class="text-purple-200/60 text-sm mt-2 font-light">
                Student Productivity Ecosystem
            </p>
        </div>

        <div class="glass-card rounded-2xl p-8 md:p-10">
            <div class="mb-8">
                <h2 class="text-white text-2xl font-semibold font-title">Daftar Akun Baru</h2>
                <p class="text-purple-200/50 text-sm mt-1">Mulai kelola aktivitas akademik dan kembangkan dirimu hari ini.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-200 text-sm space-y-1 backdrop-blur-md">
                    <div class="font-semibold text-red-300 mb-1 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        Terdapat kesalahan pengisian:
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                
                <input type="hidden" name="timezone" id="timezone" value="UTC">

                <div class="space-y-2">
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-purple-200/70">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-purple-300/40">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </span>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                            class="glass-input w-full pl-11 pr-4 py-3 rounded-xl text-sm placeholder-white/20 focus:ring-2 focus:ring-purple-500" 
                            placeholder="Masukkan nama lengkap Anda">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-purple-200/70">Email Mahasiswa</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-purple-300/40">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                            class="glass-input w-full pl-11 pr-4 py-3 rounded-xl text-sm placeholder-white/20 focus:ring-2 focus:ring-purple-500" 
                            placeholder="nama@mahasiswa.ac.id">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-purple-200/70">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-purple-300/40">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </span>
                        <input type="password" name="password" id="password" required 
                            class="glass-input w-full pl-11 pr-4 py-3 rounded-xl text-sm placeholder-white/20 focus:ring-2 focus:ring-purple-500" 
                            placeholder="Minimal 8 karakter">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-purple-200/70">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-purple-300/40">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                            </svg>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" required 
                            class="glass-input w-full pl-11 pr-4 py-3 rounded-xl text-sm placeholder-white/20 focus:ring-2 focus:ring-purple-500" 
                            placeholder="Ulangi kata sandi Anda">
                    </div>
                </div>

                <div class="flex items-start gap-2.5 pt-1">
                    <input type="checkbox" id="terms" required 
                        class="mt-1 h-4 w-4 rounded border-white/10 bg-white/5 text-purple-600 focus:ring-purple-500 focus:ring-offset-0 transition duration-150">
                    <label for="terms" class="text-xs text-purple-200/60 leading-normal">
                        Saya menyetujui <a href="#" class="text-purple-400 hover:text-purple-300 underline underline-offset-2 transition-colors">Ketentuan Layanan</a> dan <a href="#" class="text-purple-400 hover:text-purple-300 underline underline-offset-2 transition-colors">Kebijakan Privasi</a> Nexora.
                    </label>
                </div>

                <button type="submit" 
                    class="btn-gradient w-full py-3.5 rounded-xl text-white font-semibold text-sm tracking-wide mt-2">
                    Daftar Sebagai Student
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <p class="text-purple-200/50 text-xs">
                    Sudah memiliki akun? 
                    <a href="#" class="text-purple-400 hover:text-purple-300 font-semibold underline underline-offset-4 transition-colors">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
                if (tz) {
                    document.getElementById('timezone').value = tz;
                }
            } catch (e) {
                console.error("Gagal mendeteksi timezone:", e);
            }
        });
    </script>
</body>
</html>
