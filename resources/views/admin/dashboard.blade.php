<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard Nexora - Kelola pengguna dan pantau aktivitas platform.">
    <title>Admin Dashboard | Nexora</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgba(48, 10, 36, 1) 0%, rgba(26, 8, 38, 1) 45%, rgba(10, 4, 20, 1) 100%);
            min-height: 100vh;
            color: #fff;
        }

        .font-title { font-family: 'Outfit', sans-serif; }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            border-color: rgba(168, 85, 247, 0.2);
            box-shadow: 0 8px 32px rgba(95, 27, 81, 0.2);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .stat-card {
            border: 1px solid rgba(168, 85, 247, 0.15);
            border-radius: 16px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.5;
            z-index: 0;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(168, 85, 247, 0.3);
            box-shadow: 0 16px 32px rgba(124, 58, 237, 0.15);
        }

        .stat-card-purple::before { background: linear-gradient(135deg, rgba(124, 58, 237, 0.15) 0%, rgba(74, 21, 75, 0.1) 100%); }
        .stat-card-blue::before { background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.1) 100%); }
        .stat-card-emerald::before { background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.1) 100%); }

        .activity-type-task { color: #a855f7; background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); }
        .activity-type-register { color: #34d399; background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.2); }
        .activity-type-pomodoro { color: #f472b6; background: rgba(244, 114, 182, 0.1); border: 1px solid rgba(244, 114, 182, 0.2); }
        .activity-type-goal { color: #fbbf24; background: rgba(251, 191, 36, 0.1); border: 1px solid rgba(251, 191, 36, 0.2); }
        .activity-type-note { color: #60a5fa; background: rgba(96, 165, 250, 0.1); border: 1px solid rgba(96, 165, 250, 0.2); }
        .activity-type-habit { color: #2dd4bf; background: rgba(45, 212, 191, 0.1); border: 1px solid rgba(45, 212, 191, 0.2); }
        .activity-type-schedule { color: #818cf8; background: rgba(129, 140, 248, 0.1); border: 1px solid rgba(129, 140, 248, 0.2); }

        .glow-accent {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.08) 0%, rgba(0,0,0,0) 70%);
            position: fixed;
            top: -15%;
            right: -10%;
            z-index: 0;
            pointer-events: none;
        }

        .glow-accent-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(74, 21, 75, 0.1) 0%, rgba(0,0,0,0) 70%);
            position: fixed;
            bottom: -10%;
            left: -5%;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body class="relative">

    <div class="glow-accent"></div>
    <div class="glow-accent-2"></div>

    <nav class="glass-nav sticky top-0 z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h1 class="font-title text-xl font-bold bg-gradient-to-r from-purple-400 via-pink-400 to-purple-300 bg-clip-text text-transparent">
                    NEXORA
                </h1>
                <span class="text-purple-300/30 text-sm">|</span>
                <span class="text-purple-200/40 text-xs font-medium">Admin Panel</span>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-white/90">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-purple-200/40">Administrator</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-pink-500 to-red-500 flex items-center justify-center text-sm font-bold text-white shadow-lg shadow-pink-500/20">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <a href="{{ route('logout') }}" class="text-purple-300/50 hover:text-pink-400 transition-colors ml-2" title="Logout">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <main class="relative z-10 max-w-7xl mx-auto px-6 py-8">

        <div class="mb-8">
            <h2 class="font-title text-2xl font-bold text-white">Admin Dashboard 🛡️</h2>
            <p class="text-purple-200/50 text-sm mt-1">Pantau aktivitas platform dan kelola pengguna Nexora.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="stat-card stat-card-purple p-6">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-purple-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                        <span class="text-xs text-purple-300/40 font-medium">Semua Pengguna</span>
                    </div>
                    <p class="text-4xl font-bold text-white mb-1">{{ $totalUsers }}</p>
                    <p class="text-sm text-purple-200/50">Total Users</p>
                </div>
            </div>

            <div class="stat-card stat-card-blue p-6">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a23.54 23.54 0 0 0-2.688 6.671A12.021 12.021 0 0 1 2.25 12c0-2.16.57-4.19 1.565-5.94a23.54 23.54 0 0 0 2.445 4.087Zm15.482 0a23.54 23.54 0 0 1 2.445-4.088A11.943 11.943 0 0 1 21.75 12c0 1.72-.363 3.354-1.018 4.83a23.568 23.568 0 0 1-2.49-6.683ZM12 2.25c-2.291 0-4.545.16-6.755.463a1.502 1.502 0 0 0-1.078 1.135 48.29 48.29 0 0 0-.474 6.3c2.893-.484 5.842-.725 8.307-.725 2.465 0 5.414.24 8.307.725a48.299 48.299 0 0 0-.474-6.3 1.5 1.5 0 0 0-1.078-1.136A53.768 53.768 0 0 0 12 2.25Z" />
                            </svg>
                        </div>
                        <span class="text-xs text-blue-300/40 font-medium">Mahasiswa</span>
                    </div>
                    <p class="text-4xl font-bold text-white mb-1">{{ $totalStudents }}</p>
                    <p class="text-sm text-purple-200/50">Total Students</p>
                </div>
            </div>

            <div class="stat-card stat-card-emerald p-6">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-emerald-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                            </svg>
                        </div>
                        <span class="text-xs text-emerald-300/40 font-medium">Administrator</span>
                    </div>
                    <p class="text-4xl font-bold text-white mb-1">{{ $totalAdmins }}</p>
                    <p class="text-sm text-purple-200/50">Total Admins</p>
                </div>
            </div>
        </div>

        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/15 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-purple-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h3 class="font-title font-semibold text-white text-lg">Recent Activities</h3>
                </div>
                <span class="text-xs text-purple-200/40">Aktivitas terbaru pengguna</span>
            </div>

            <div class="space-y-3">
                @foreach($recentActivities as $activity)
                    <div class="flex items-center gap-4 p-4 rounded-xl transition-colors" style="background: rgba(255,255,255,0.02);">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 text-sm font-bold" style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(244, 114, 182, 0.2));">
                            {{ strtoupper(substr($activity['user'], 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-white/90">
                                <span class="font-semibold">{{ $activity['user'] }}</span>
                                <span class="text-purple-200/60"> — {{ $activity['action'] }}</span>
                            </p>
                            <p class="text-xs text-purple-200/35 mt-0.5">{{ $activity['time'] }}</p>
                        </div>
                        <span class="text-[11px] font-medium px-2.5 py-1 rounded-lg flex-shrink-0 activity-type-{{ $activity['type'] }}">
                            @switch($activity['type'])
                                @case('task') Tugas @break
                                @case('register') Registrasi @break
                                @case('pomodoro') Pomodoro @break
                                @case('goal') Target @break
                                @case('note') Catatan @break
                                @case('habit') Kebiasaan @break
                                @case('schedule') Jadwal @break
                            @endswitch
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

</body>
</html>
