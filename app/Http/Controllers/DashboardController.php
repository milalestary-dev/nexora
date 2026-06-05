<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $todayTasks = [
            ['title' => 'Kumpulkan Laporan Praktikum Fisika', 'priority' => 'high', 'deadline' => '23:59', 'category' => 'Akademik', 'completed' => false],
            ['title' => 'Review Materi UTS Kalkulus II', 'priority' => 'high', 'deadline' => '20:00', 'category' => 'Akademik', 'completed' => false],
            ['title' => 'Buat Slide Presentasi Kelompok', 'priority' => 'medium', 'deadline' => '18:00', 'category' => 'Tugas Kelompok', 'completed' => true],
            ['title' => 'Daftar Seminar Nasional', 'priority' => 'low', 'deadline' => '17:00', 'category' => 'Organisasi', 'completed' => true],
            ['title' => 'Baca Jurnal Machine Learning', 'priority' => 'medium', 'deadline' => '21:00', 'category' => 'Pribadi', 'completed' => false],
        ];

        $todaySchedule = [
            ['subject' => 'Kalkulus II', 'time' => '08:00 - 09:40', 'location' => 'Ruang 301', 'status' => 'done'],
            ['subject' => 'Fisika Dasar', 'time' => '10:00 - 11:40', 'location' => 'Lab Fisika', 'status' => 'done'],
            ['subject' => 'Pemrograman Web', 'time' => '13:00 - 14:40', 'location' => 'Lab Komputer 2', 'status' => 'ongoing'],
            ['subject' => 'Bahasa Inggris', 'time' => '15:00 - 16:40', 'location' => 'Ruang 205', 'status' => 'upcoming'],
        ];

        $goals = [
            ['title' => 'IPK Semester Ini ≥ 3.75', 'current' => 3.6, 'target' => 3.75, 'percentage' => 85, 'deadline' => '30 Jun 2026'],
            ['title' => 'Selesaikan 50 Soal Coding', 'current' => 32, 'target' => 50, 'percentage' => 64, 'deadline' => '15 Jul 2026'],
            ['title' => 'Baca 12 Buku Semester Ini', 'current' => 8, 'target' => 12, 'percentage' => 67, 'deadline' => '30 Jun 2026'],
        ];

        $pomodoro = [
            'today_sessions' => 6,
            'today_focus_minutes' => 150,
            'today_break_minutes' => 30,
            'weekly_sessions' => 28,
            'weekly_focus_hours' => 11.5,
            'streak_days' => 5,
        ];

        return view('dashboard', compact('user', 'todayTasks', 'todaySchedule', 'goals', 'pomodoro'));
    }
}
