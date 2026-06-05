<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Role;
use App\Models\Task;
use App\Models\Schedule;
use App\Models\Goal;
use App\Models\PomodoroSession;
use App\Models\Activity;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $studentRole = Role::where('name', 'Student')->first();
        $adminRole = Role::where('name', 'Admin')->first();

        $student = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'test@example.com',
            'role_id' => $studentRole?->id,
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin Nexora',
            'email' => 'admin@nexora.id',
            'role_id' => $adminRole?->id,
        ]);

        Task::create([
            'user_id' => $student->id,
            'title' => 'Kumpulkan Laporan Praktikum Fisika',
            'priority' => 'high',
            'category' => 'Akademik',
            'deadline' => '23:59',
            'completed' => false,
        ]);

        Task::create([
            'user_id' => $student->id,
            'title' => 'Review Materi UTS Kalkulus II',
            'priority' => 'high',
            'category' => 'Akademik',
            'deadline' => '20:00',
            'completed' => false,
        ]);

        Task::create([
            'user_id' => $student->id,
            'title' => 'Buat Slide Presentasi Kelompok',
            'priority' => 'medium',
            'category' => 'Tugas Kelompok',
            'deadline' => '18:00',
            'completed' => true,
        ]);

        Task::create([
            'user_id' => $student->id,
            'title' => 'Daftar Seminar Nasional',
            'priority' => 'low',
            'category' => 'Organisasi',
            'deadline' => '17:00',
            'completed' => true,
        ]);

        Task::create([
            'user_id' => $student->id,
            'title' => 'Baca Jurnal Machine Learning',
            'priority' => 'medium',
            'category' => 'Pribadi',
            'deadline' => '21:00',
            'completed' => false,
        ]);

        Schedule::create([
            'user_id' => $student->id,
            'subject' => 'Kalkulus II',
            'time' => '08:00 - 09:40',
            'location' => 'Ruang 301',
            'status' => 'done',
        ]);

        Schedule::create([
            'user_id' => $student->id,
            'subject' => 'Fisika Dasar',
            'time' => '10:00 - 11:40',
            'location' => 'Lab Fisika',
            'status' => 'done',
        ]);

        Schedule::create([
            'user_id' => $student->id,
            'subject' => 'Pemrograman Web',
            'time' => '13:00 - 14:40',
            'location' => 'Lab Komputer 2',
            'status' => 'ongoing',
        ]);

        Schedule::create([
            'user_id' => $student->id,
            'subject' => 'Bahasa Inggris',
            'time' => '15:00 - 16:40',
            'location' => 'Ruang 205',
            'status' => 'upcoming',
        ]);

        Goal::create([
            'user_id' => $student->id,
            'title' => 'IPK Semester Ini ≥ 3.75',
            'current' => 3.60,
            'target' => 3.75,
            'deadline' => '30 Jun 2026',
        ]);

        Goal::create([
            'user_id' => $student->id,
            'title' => 'Selesaikan 50 Soal Coding',
            'current' => 32,
            'target' => 50,
            'deadline' => '15 Jul 2026',
        ]);

        Goal::create([
            'user_id' => $student->id,
            'title' => 'Baca 12 Buku Semester Ini',
            'current' => 8,
            'target' => 12,
            'deadline' => '30 Jun 2026',
        ]);

        for ($i = 0; $i < 6; $i++) {
            PomodoroSession::create([
                'user_id' => $student->id,
                'duration_minutes' => 25,
                'created_at' => Carbon::now()->subMinutes($i * 40),
            ]);
        }

        for ($i = 0; $i < 22; $i++) {
            PomodoroSession::create([
                'user_id' => $student->id,
                'duration_minutes' => 25,
                'created_at' => Carbon::now()->subDays(rand(1, 6)),
            ]);
        }

        Activity::create([
            'user_id' => $student->id,
            'action' => 'Mendaftar akun baru',
            'type' => 'register',
            'created_at' => Carbon::now()->subMinutes(12),
        ]);

        Activity::create([
            'user_id' => $student->id,
            'action' => 'Menyelesaikan tugas "Slide Presentasi Kelompok"',
            'type' => 'task',
            'created_at' => Carbon::now()->subMinutes(5),
        ]);
    }
}
