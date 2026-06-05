<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Nexora - Pusat produktivitas mahasiswa. Pantau tugas, jadwal, target, dan fokus belajar Anda.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            transition: width 0.5s ease-in-out;
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
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: conic-gradient(#a855f7 0deg, rgba(255,255,255,0.05) 0deg);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .pomodoro-ring-inner {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(10, 4, 20, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 4, 20, 0.8);
            backdrop-filter: blur(8px);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .modal-backdrop.show {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-content {
            background: rgba(30, 15, 45, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.6);
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            padding: 30px;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal-backdrop.show .modal-content {
            transform: scale(1);
        }

        .input-glow:focus {
            outline: none;
            border-color: #a855f7;
            box-shadow: 0 0 10px rgba(168, 85, 247, 0.5);
        }
    </style>
</head>
<body class="relative">

    <div class="glow-accent"></div>
    <div class="glow-accent-2"></div>

    <nav class="glass-nav relative z-50 px-6 py-4">
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
                <p id="stat-tasks" class="text-2xl font-bold text-white">{{ $todayTasks->where('completed', true)->count() }}/{{ $todayTasks->count() }}</p>
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
                <p class="text-2xl font-bold text-white">{{ $todaySchedule->count() }}</p>
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
                <p class="text-2xl font-bold text-white">{{ $goals->count() }}</p>
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
                        <div class="flex items-center gap-3">
                            <span id="stat-tasks-left" class="text-xs text-purple-200/40">{{ $todayTasks->where('completed', false)->count() }} tersisa</span>
                            <button onclick="toggleModal('modal-task', true)" class="px-2.5 py-1 rounded bg-purple-500/10 hover:bg-purple-500/25 border border-purple-500/20 text-purple-300 text-xs font-semibold">+ Tambah</button>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach($todayTasks as $task)
                            <div id="task-container-{{ $task->id }}" class="flex items-center gap-3 p-3 rounded-xl {{ $task->completed ? 'task-completed' : '' }}" style="background: rgba(255,255,255,0.02);">
                                <button onclick="toggleTaskCompletion({{ $task->id }})" class="w-5 h-5 rounded-md border flex items-center justify-center flex-shrink-0 transition-colors {{ $task->completed ? 'border-purple-500/40 bg-purple-500/20' : 'border-white/15 hover:border-purple-400' }}">
                                    <svg id="task-check-{{ $task->id }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3 text-purple-400 {{ $task->completed ? '' : 'hidden' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                </button>
                                <div class="flex-1 min-w-0">
                                    <p class="task-title text-sm text-white/90 truncate">{{ $task->title }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="category-badge">{{ $task->category }}</span>
                                        <span class="text-[11px] text-purple-200/40">{{ $task->deadline }}</span>
                                    </div>
                                </div>
                                <div class="w-2 h-2 rounded-full flex-shrink-0 priority-dot-{{ $task->priority }}"></div>
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
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-purple-200/40">{{ now()->format('d M Y') }}</span>
                            <button onclick="toggleModal('modal-schedule', true)" class="px-2.5 py-1 rounded bg-blue-500/10 hover:bg-blue-500/25 border border-blue-500/20 text-blue-300 text-xs font-semibold">+ Tambah</button>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach($todaySchedule as $schedule)
                            <div class="flex items-center gap-4 p-3 rounded-xl" style="background: rgba(255,255,255,0.02);">
                                <div class="text-center flex-shrink-0" style="min-width: 90px;">
                                    <p class="text-xs font-medium text-white/80">{{ $schedule->time }}</p>
                                </div>
                                <div class="w-px h-10 bg-white/10 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-white/90">{{ $schedule->subject }}</p>
                                    <p class="text-xs text-purple-200/40 mt-0.5">📍 {{ $schedule->location }}</p>
                                </div>
                                <span class="text-[11px] font-medium px-2.5 py-1 rounded-lg flex-shrink-0 status-{{ $schedule->status }}">
                                    {{ $schedule->status === 'done' ? 'Selesai' : ($schedule->status === 'ongoing' ? 'Berlangsung' : 'Mendatang') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">

                <div class="glass-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/15 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-emerald-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                                </svg>
                            </div>
                            <h3 class="font-title font-semibold text-white">Goal Progress</h3>
                        </div>
                        <button onclick="toggleModal('modal-goal', true)" class="px-2.5 py-1 rounded bg-emerald-500/10 hover:bg-emerald-500/25 border border-emerald-500/20 text-emerald-300 text-xs font-semibold">+ Tambah</button>
                    </div>

                    <div class="space-y-5">
                        @foreach($goals as $goal)
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm text-white/85 truncate pr-2">{{ $goal->title }}</p>
                                    <div class="flex items-center gap-2">
                                        <span id="goal-pct-{{ $goal->id }}" class="text-xs font-semibold text-purple-300 flex-shrink-0">{{ $goal->percentage }}%</span>
                                        <button onclick="incrementGoalProgress({{ $goal->id }})" class="px-1.5 py-0.5 rounded bg-emerald-500/20 hover:bg-emerald-500/40 text-[10px] font-bold text-emerald-300 border border-emerald-500/30">+1</button>
                                    </div>
                                </div>
                                <div class="progress-bar-bg h-2">
                                    <div id="goal-bar-{{ $goal->id }}" class="progress-bar-fill h-2" style="width: {{ $goal->percentage }}%;"></div>
                                </div>
                                <p class="text-[11px] text-purple-200/35 mt-1.5">Target: {{ $goal->deadline }}</p>
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

                    <div class="flex flex-col items-center justify-center mb-5">
                        <div id="pomodoro-ring-el" class="pomodoro-ring">
                            <div class="pomodoro-ring-inner">
                                <span id="pomo-timer-display" class="text-xl font-bold text-white cursor-pointer" title="Double click to instantly complete for testing">25:00</span>
                                <span class="text-[10px] text-purple-200/50">focus time</span>
                            </div>
                        </div>
                        <div class="flex gap-2 mt-4">
                            <button id="pomo-start" onclick="startPomodoro()" class="px-4 py-1.5 rounded-lg bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold transition-colors">Mulai</button>
                            <button id="pomo-pause" onclick="pausePomodoro()" class="px-4 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition-colors hidden">Jeda</button>
                            <button onclick="resetPomodoro()" class="px-4 py-1.5 rounded-lg bg-red-500/20 hover:bg-red-500/35 text-red-400 text-xs font-semibold transition-colors">Reset</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl text-center" style="background: rgba(255,255,255,0.02);">
                            <p id="pomo-today-sessions" class="text-lg font-bold text-white">{{ $pomodoro['today_sessions'] }}</p>
                            <p class="text-[11px] text-purple-200/40">Sesi Hari Ini</p>
                        </div>
                        <div class="p-3 rounded-xl text-center" style="background: rgba(255,255,255,0.02);">
                            <p id="pomo-today-minutes" class="text-lg font-bold text-white">{{ $pomodoro['today_focus_minutes'] }}</p>
                            <p class="text-[11px] text-purple-200/40">Menit Fokus</p>
                        </div>
                        <div class="p-3 rounded-xl text-center" style="background: rgba(255,255,255,0.02);">
                            <p id="pomo-weekly-sessions" class="text-lg font-bold text-white">{{ $pomodoro['weekly_sessions'] }}</p>
                            <p class="text-[11px] text-purple-200/40">Sesi Minggu Ini</p>
                        </div>
                        <div class="p-3 rounded-xl text-center" style="background: rgba(255,255,255,0.02);">
                            <p id="pomo-weekly-hours" class="text-lg font-bold text-white">{{ $pomodoro['weekly_focus_hours'] }}</p>
                            <p class="text-[11px] text-purple-200/40">Jam Fokus Mingguan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Add Task -->
    <div id="modal-task" class="modal-backdrop">
        <div class="modal-content">
            <h3 class="font-title text-xl font-bold mb-4 text-purple-300">Tambah Tugas Baru</h3>
            <form action="{{ route('tasks.create') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-purple-200/60 mb-1">Judul Tugas</label>
                        <input type="text" name="title" required class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-purple-200/60 mb-1">Prioritas</label>
                            <select name="priority" required class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white" style="color: #000;">
                                <option value="high" style="color: #000;">Tinggi (High)</option>
                                <option value="medium" style="color: #000;">Sedang (Medium)</option>
                                <option value="low" style="color: #000;">Rendah (Low)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-purple-200/60 mb-1">Kategori</label>
                            <input type="text" name="category" required placeholder="Akademik, Pribadi" class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-purple-200/60 mb-1">Batas Waktu (Deadline)</label>
                        <input type="text" name="deadline" required placeholder="23:59 atau 12 Jun 2026" class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleModal('modal-task', false)" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-white text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold shadow-lg shadow-purple-500/20">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Add Schedule -->
    <div id="modal-schedule" class="modal-backdrop">
        <div class="modal-content">
            <h3 class="font-title text-xl font-bold mb-4 text-blue-300">Tambah Jadwal Baru</h3>
            <form action="{{ route('schedules.create') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-purple-200/60 mb-1">Mata Kuliah / Kegiatan</label>
                        <input type="text" name="subject" required class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-purple-200/60 mb-1">Waktu</label>
                        <input type="text" name="time" required placeholder="08:00 - 09:40" class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-purple-200/60 mb-1">Lokasi</label>
                            <input type="text" name="location" required placeholder="Ruang 301, Lab" class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-purple-200/60 mb-1">Status</label>
                            <select name="status" required class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white" style="color: #000;">
                                <option value="upcoming" style="color: #000;">Mendatang</option>
                                <option value="ongoing" style="color: #000;">Berlangsung</option>
                                <option value="done" style="color: #000;">Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleModal('modal-schedule', false)" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-white text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-lg shadow-blue-500/20">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Add Goal -->
    <div id="modal-goal" class="modal-backdrop">
        <div class="modal-content">
            <h3 class="font-title text-xl font-bold mb-4 text-emerald-300">Tambah Target Baru</h3>
            <form action="{{ route('goals.create') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-purple-200/60 mb-1">Judul Target</label>
                        <input type="text" name="title" required placeholder="Selesaikan 50 Soal Coding" class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-purple-200/60 mb-1">Nilai Sekarang</label>
                            <input type="number" step="0.01" name="current" required value="0" class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-purple-200/60 mb-1">Nilai Sasaran</label>
                            <input type="number" step="0.01" name="target" required class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-purple-200/60 mb-1">Tenggat Waktu</label>
                        <input type="text" name="deadline" required placeholder="30 Jun 2026" class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm input-glow text-white">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="toggleModal('modal-goal', false)" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-white text-xs font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-lg shadow-emerald-500/20">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id, show) {
            const modal = document.getElementById(id);
            if (show) {
                modal.classList.add('show');
            } else {
                modal.classList.remove('show');
            }
        }

        async function toggleTaskCompletion(taskId) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const response = await fetch(`/tasks/${taskId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                const data = await response.json();
                if (data.success) {
                    const container = document.getElementById(`task-container-${taskId}`);
                    const checkIcon = document.getElementById(`task-check-${taskId}`);
                    
                    if (data.completed) {
                        container.classList.add('task-completed');
                        checkIcon.classList.remove('hidden');
                    } else {
                        container.classList.remove('task-completed');
                        checkIcon.classList.add('hidden');
                    }
                    
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error toggling task:', error);
            }
        }

        async function incrementGoalProgress(goalId) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const response = await fetch(`/goals/${goalId}/increment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                const data = await response.json();
                if (data.success) {
                    document.getElementById(`goal-pct-${goalId}`).innerText = `${data.percentage}%`;
                    document.getElementById(`goal-bar-${goalId}`).style.width = `${data.percentage}%`;
                }
            } catch (error) {
                console.error('Error incrementing goal:', error);
            }
        }

        let pomodoroInterval = null;
        let pomodoroTimeLeft = 25 * 60; // 25 minutes
        let pomodoroRunning = false;

        function updatePomodoroTimerDisplay() {
            const minutes = Math.floor(pomodoroTimeLeft / 60);
            const seconds = pomodoroTimeLeft % 60;
            document.getElementById('pomo-timer-display').innerText = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            const total = 25 * 60;
            const elapsed = total - pomodoroTimeLeft;
            const deg = (elapsed / total) * 360;
            document.getElementById('pomodoro-ring-el').style.background = 
                `conic-gradient(#a855f7 0deg, #7c3aed ${deg}deg, rgba(255,255,255,0.05) ${deg}deg)`;
        }

        function startPomodoro() {
            if (pomodoroRunning) return;
            pomodoroRunning = true;
            document.getElementById('pomo-start').classList.add('hidden');
            document.getElementById('pomo-pause').classList.remove('hidden');

            pomodoroInterval = setInterval(async () => {
                if (pomodoroTimeLeft > 0) {
                    pomodoroTimeLeft--;
                    updatePomodoroTimerDisplay();
                } else {
                    clearInterval(pomodoroInterval);
                    pomodoroRunning = false;
                    document.getElementById('pomo-start').classList.remove('hidden');
                    document.getElementById('pomo-pause').classList.add('hidden');
                    await completePomodoroSession(25);
                }
            }, 1000);
        }

        function pausePomodoro() {
            clearInterval(pomodoroInterval);
            pomodoroRunning = false;
            document.getElementById('pomo-start').classList.remove('hidden');
            document.getElementById('pomo-pause').classList.add('hidden');
        }

        function resetPomodoro() {
            clearInterval(pomodoroInterval);
            pomodoroRunning = false;
            pomodoroTimeLeft = 25 * 60;
            updatePomodoroTimerDisplay();
            document.getElementById('pomo-start').classList.remove('hidden');
            document.getElementById('pomo-pause').classList.add('hidden');
        }

        async function completePomodoroSession(minutes) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const response = await fetch('/pomodoro', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ duration_minutes: minutes })
                });
                const data = await response.json();
                if (data.success) {
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error logging pomodoro:', error);
            }
        }

        document.getElementById('pomo-timer-display').addEventListener('dblclick', async () => {
            await completePomodoroSession(25);
        });

        updatePomodoroTimerDisplay();
    </script>
</body>
</html>
