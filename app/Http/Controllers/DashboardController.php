<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Schedule;
use App\Models\Goal;
use App\Models\PomodoroSession;
use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $todayTasks = Task::where('user_id', $user->id)
            ->orderBy('completed')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->get();

        $todaySchedule = Schedule::where('user_id', $user->id)
            ->orderBy('time')
            ->get();

        $goals = Goal::where('user_id', $user->id)
            ->get()
            ->map(function ($goal) {
                $goal->percentage = $goal->target > 0 ? min(100, round(($goal->current / $goal->target) * 100)) : 0;
                return $goal;
            });

        $todaySessions = PomodoroSession::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $todayFocusMinutes = PomodoroSession::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->sum('duration_minutes');

        $todayBreakMinutes = round($todayFocusMinutes / 5);

        $weeklySessions = PomodoroSession::where('user_id', $user->id)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $weeklyFocusMinutes = PomodoroSession::where('user_id', $user->id)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('duration_minutes');
        $weeklyFocusHours = round($weeklyFocusMinutes / 60, 1);

        $dates = PomodoroSession::where('user_id', $user->id)
            ->selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->map(fn($d) => Carbon::parse($d));

        $streakDays = 0;
        if ($dates->count() > 0) {
            if ($dates[0]->isToday()) {
                $streakDays = 1;
                for ($i = 1; $i < $dates->count(); $i++) {
                    if ($dates[$i]->equalTo($dates[$i - 1]->copy()->subDay())) {
                        $streakDays++;
                    } else {
                        break;
                    }
                }
            } elseif ($dates[0]->isYesterday()) {
                $streakDays = 1;
                for ($i = 1; $i < $dates->count(); $i++) {
                    if ($dates[$i]->equalTo($dates[$i - 1]->copy()->subDay())) {
                        $streakDays++;
                    } else {
                        break;
                    }
                }
            }
        }

        $pomodoro = [
            'today_sessions' => $todaySessions,
            'today_focus_minutes' => $todayFocusMinutes,
            'today_break_minutes' => $todayBreakMinutes,
            'weekly_sessions' => $weeklySessions,
            'weekly_focus_hours' => $weeklyFocusHours,
            'streak_days' => $streakDays ?: 1,
        ];

        return view('dashboard', compact('user', 'todayTasks', 'todaySchedule', 'goals', 'pomodoro'));
    }

    public function createTask(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'in:high,medium,low'],
            'category' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'string', 'max:255'],
        ]);

        Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'priority' => $request->priority,
            'category' => $request->category,
            'deadline' => $request->deadline,
            'completed' => false,
        ]);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Menambahkan tugas "' . $request->title . '"',
            'type' => 'task',
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function toggleTask(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);

        $task->update([
            'completed' => !$task->completed,
        ]);

        if ($task->completed) {
            Activity::create([
                'user_id' => auth()->id(),
                'action' => 'Menyelesaikan tugas "' . $task->title . '"',
                'type' => 'task',
            ]);
        }

        return response()->json([
            'success' => true,
            'completed' => $task->completed,
        ]);
    }

    public function createSchedule(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'time' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:done,ongoing,upcoming'],
        ]);

        Schedule::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'time' => $request->time,
            'location' => $request->location,
            'status' => $request->status,
        ]);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Menambahkan jadwal kuliah "' . $request->subject . '"',
            'type' => 'schedule',
        ]);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function createGoal(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'current' => ['required', 'numeric', 'min:0'],
            'target' => ['required', 'numeric', 'gt:0'],
            'deadline' => ['required', 'string', 'max:255'],
        ]);

        Goal::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'current' => $request->current,
            'target' => $request->target,
            'deadline' => $request->deadline,
        ]);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Menambahkan target "' . $request->title . '"',
            'type' => 'goal',
        ]);

        return redirect()->back()->with('success', 'Target berhasil ditambahkan.');
    }

    public function incrementGoal(Goal $goal)
    {
        abort_if($goal->user_id !== auth()->id(), 403);

        $goal->increment('current', 1);

        if ($goal->current > $goal->target) {
            $goal->update(['current' => $goal->target]);
        }

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Memperbarui target "' . $goal->title . '"',
            'type' => 'goal',
        ]);

        return response()->json([
            'success' => true,
            'current' => $goal->current,
            'percentage' => min(100, round(($goal->current / $goal->target) * 100)),
        ]);
    }

    public function logPomodoro(Request $request)
    {
        $request->validate([
            'duration_minutes' => ['required', 'integer', 'min:1'],
        ]);

        PomodoroSession::create([
            'user_id' => auth()->id(),
            'duration_minutes' => $request->duration_minutes,
        ]);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Menyelesaikan sesi Pomodoro (' . $request->duration_minutes . ' menit)',
            'type' => 'pomodoro',
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
