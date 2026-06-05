<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Nexora - Pusat produktivitas mahasiswa. Pantau tugas, jadwal, target, dan fokus belajar Anda.">
    <title>Dashboard | Nexora</title>

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
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(74, 21, 75, 0.15) 100%);
            border: 1px solid rgba(168, 85, 247, 0.15);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: rgba(168, 85, 247, 0.3);
            box-shadow: 0 12px 24px rgba(124, 58, 237, 0.15);
        }

        .progress-bar-bg {
            background: rgba(255, 255, 255, 0.06);
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-bar-fill {
            background: linear-gradient(90deg, #7c3aed, #a855f7, #c084fc);
            border-radius: 999px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .priority-high { color: #f87171; }
        .priority-medium { color: #fbbf24; }
        .priority-low { color: #34d399; }

        .priority-dot-high { background: #f87171; }
        .priority-dot-medium { background: #fbbf24; }
        .priority-dot-low { background: #34d399; }

        .status-done { color: #34d399; background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.2); }
        .status-ongoing { color: #a855f7; background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); }
        .status-upcoming { color: #60a5fa; background: rgba(96, 165, 250, 0.1); border: 1px solid rgba(96, 165, 250, 0.2); }

        .category-badge {
            background: rgba(168, 85, 247, 0.15);
            border: 1px solid rgba(168, 85, 247, 0.25);
            color: #c084fc;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 6px;
            font-weight: 500;
        }

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

        .task-completed { opacity: 0.5; }
        .task-completed .task-title { text-decoration: line-through; }

        .pomodoro-ring {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: conic-gradient(#a855f7 0deg, #7c3aed 216deg, rgba(255,255,255,0.05) 216deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pomodoro-ring-inner {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(10, 4, 20, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
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
                <span class="text-purple-200/40 text-xs font-medium">Dashboard</span>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-white/90">{{ $user->name }}</p>
                    <p class="text-xs text-purple-200/40">{{ $user->role->name }}</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-sm font-bold text-white shadow-lg shadow-purple-500/20">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
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
            <h2 class="font-title text-2xl font-bold text-white">Selamat Datang, {{ explode(' ', $user->name)[0] }}! 👋</h2>
            <p class="text-purple-200/50 text-sm mt-1">Berikut ringkasan produktivitas kamu hari ini.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="stat-card p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/15 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-white">{{ count(array_filter($todayTasks, fn($t) => $t['completed'])) }}/{{ count($todayTasks) }}</p>
                <p class="text-xs text-purple-200/50 mt-1">Tugas Selesai</p>
            </div>

            <div class="stat-card p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-white">{{ count($todaySchedule) }}</p>
                <p class="text-xs text-purple-200/50 mt-1">Jadwal Hari Ini</p>
            </div>

            <div class="stat-card p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-emerald-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-white">{{ count($goals) }}</p>
                <p class="text-xs text-purple-200/50 mt-1">Target Aktif</p>
            </div>

            <div class="stat-card p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-pink-500/15 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-pink-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-white">{{ $pomodoro['streak_days'] }} Hari</p>
                <p class="text-xs text-purple-200/50 mt-1">Streak Fokus</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="glass-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-500/15 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-purple-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                </svg>
                            </div>
                            <h3 class="font-title font-semibold text-white">Today's Tasks</h3>
                        </div>
                        <span class="text-xs text-purple-200/40">{{ count(array_filter($todayTasks, fn($t) => !$t['completed'])) }} tersisa</span>
                    </div>

                    <div class="space-y-3">
                        @foreach($todayTasks as $task)
                            <div class="flex items-center gap-3 p-3 rounded-xl {{ $task['completed'] ? 'task-completed' : '' }}" style="background: rgba(255,255,255,0.02);">
                                <div class="w-5 h-5 rounded-md border flex items-center justify-center flex-shrink-0 {{ $task['completed'] ? 'border-purple-500/40 bg-purple-500/20' : 'border-white/15' }}">
                                    @if($task['completed'])
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 text-purple-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="task-title text-sm text-white/90 truncate">{{ $task['title'] }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="category-badge">{{ $task['category'] }}</span>
                                        <span class="text-[11px] text-purple-200/40">{{ $task['deadline'] }}</span>
                                    </div>
                                </div>
                                <div class="w-2 h-2 rounded-full flex-shrink-0 priority-dot-{{ $task['priority'] }}"></div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="glass-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/15 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <h3 class="font-title font-semibold text-white">Today's Schedule</h3>
                        </div>
                        <span class="text-xs text-purple-200/40">{{ now()->format('d M Y') }}</span>
                    </div>

                    <div class="space-y-3">
                        @foreach($todaySchedule as $schedule)
                            <div class="flex items-center gap-4 p-3 rounded-xl" style="background: rgba(255,255,255,0.02);">
                                <div class="text-center flex-shrink-0" style="min-width: 90px;">
                                    <p class="text-xs font-medium text-white/80">{{ $schedule['time'] }}</p>
                                </div>
                                <div class="w-px h-10 bg-white/10 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-white/90">{{ $schedule['subject'] }}</p>
                                    <p class="text-xs text-purple-200/40 mt-0.5">📍 {{ $schedule['location'] }}</p>
                                </div>
                                <span class="text-[11px] font-medium px-2.5 py-1 rounded-lg flex-shrink-0 status-{{ $schedule['status'] }}">
                                    {{ $schedule['status'] === 'done' ? 'Selesai' : ($schedule['status'] === 'ongoing' ? 'Berlangsung' : 'Mendatang') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">

                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/15 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-emerald-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                        </div>
                        <h3 class="font-title font-semibold text-white">Goal Progress</h3>
                    </div>

                    <div class="space-y-5">
                        @foreach($goals as $goal)
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm text-white/85 truncate pr-2">{{ $goal['title'] }}</p>
                                    <span class="text-xs font-semibold text-purple-300 flex-shrink-0">{{ $goal['percentage'] }}%</span>
                                </div>
                                <div class="progress-bar-bg h-2">
                                    <div class="progress-bar-fill h-2" style="width: {{ $goal['percentage'] }}%;"></div>
                                </div>
                                <p class="text-[11px] text-purple-200/35 mt-1.5">Target: {{ $goal['deadline'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-pink-500/15 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-pink-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <h3 class="font-title font-semibold text-white">Pomodoro Summary</h3>
                    </div>

                    <div class="flex items-center justify-center mb-5">
                        <div class="pomodoro-ring">
                            <div class="pomodoro-ring-inner">
                                <span class="text-xl font-bold text-white">{{ $pomodoro['today_sessions'] }}</span>
                                <span class="text-[10px] text-purple-200/50">sesi hari ini</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl text-center" style="background: rgba(255,255,255,0.02);">
                            <p class="text-lg font-bold text-white">{{ $pomodoro['today_focus_minutes'] }}</p>
                            <p class="text-[11px] text-purple-200/40">Menit Fokus</p>
                        </div>
                        <div class="p-3 rounded-xl text-center" style="background: rgba(255,255,255,0.02);">
                            <p class="text-lg font-bold text-white">{{ $pomodoro['today_break_minutes'] }}</p>
                            <p class="text-[11px] text-purple-200/40">Menit Istirahat</p>
                        </div>
                        <div class="p-3 rounded-xl text-center" style="background: rgba(255,255,255,0.02);">
                            <p class="text-lg font-bold text-white">{{ $pomodoro['weekly_sessions'] }}</p>
                            <p class="text-[11px] text-purple-200/40">Sesi Minggu Ini</p>
                        </div>
                        <div class="p-3 rounded-xl text-center" style="background: rgba(255,255,255,0.02);">
                            <p class="text-lg font-bold text-white">{{ $pomodoro['weekly_focus_hours'] }}</p>
                            <p class="text-[11px] text-purple-200/40">Jam Fokus Mingguan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
