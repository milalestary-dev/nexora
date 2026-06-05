<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalStudents = User::whereHas('role', fn($q) => $q->where('name', 'Student'))->count();
        $totalAdmins = User::whereHas('role', fn($q) => $q->where('name', 'Admin'))->count();

        $recentActivities = [
            ['user' => 'Budi Santoso', 'action' => 'Menyelesaikan tugas "Laporan Praktikum Fisika"', 'time' => '5 menit lalu', 'type' => 'task'],
            ['user' => 'Siti Nurhaliza', 'action' => 'Mendaftar akun baru', 'time' => '12 menit lalu', 'type' => 'register'],
            ['user' => 'Ahmad Rizki', 'action' => 'Menyelesaikan sesi Pomodoro (25 menit)', 'time' => '30 menit lalu', 'type' => 'pomodoro'],
            ['user' => 'Dewi Lestari', 'action' => 'Mencapai target "Baca 10 Buku"', 'time' => '1 jam lalu', 'type' => 'goal'],
            ['user' => 'Budi Santoso', 'action' => 'Menambahkan catatan "Ringkasan Kalkulus II"', 'time' => '1 jam lalu', 'type' => 'note'],
            ['user' => 'Rina Wulandari', 'action' => 'Menyelesaikan kebiasaan "Belajar Coding"', 'time' => '2 jam lalu', 'type' => 'habit'],
            ['user' => 'Ahmad Rizki', 'action' => 'Memperbarui target "IPK ≥ 3.75"', 'time' => '3 jam lalu', 'type' => 'goal'],
            ['user' => 'Dewi Lestari', 'action' => 'Menambahkan jadwal belajar "Fisika Dasar"', 'time' => '4 jam lalu', 'type' => 'schedule'],
        ];

        return view('admin.dashboard', compact('totalUsers', 'totalStudents', 'totalAdmins', 'recentActivities'));
    }
}
