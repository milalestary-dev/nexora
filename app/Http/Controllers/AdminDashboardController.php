<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Activity;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalStudents = User::whereHas('role', fn($q) => $q->where('name', 'Student'))->count();
        $totalAdmins = User::whereHas('role', fn($q) => $q->where('name', 'Admin'))->count();

        $recentActivities = Activity::with('user')
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get()
            ->map(function ($activity) {
                return [
                    'user' => $activity->user->name ?? 'User',
                    'action' => $activity->action,
                    'time' => $activity->created_at->diffForHumans(),
                    'type' => $activity->type,
                ];
            });

        return view('admin.dashboard', compact('totalUsers', 'totalStudents', 'totalAdmins', 'recentActivities'));
    }
}
