<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\Santri;
use App\Models\Hafalan;
use App\Models\Murajaah;
use App\Models\GroupMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin Quran Tracker',
            'email' => 'admin@qurantracker.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create sample users
        $user1 = User::create([
            'name' => 'Ahmad Santri',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name' => 'Fatimah Santri',
            'email' => 'fatimah@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create sample groups
        $group1 = Group::create([
            'name' => 'Group Tahfidz Al-Fatihah',
            'description' => 'Group untuk menghafal surah Al-Fatihah dan surah-surah pendek',
            'admin_id' => $admin->id,
            'code' => 'FATIHAH',
            'is_active' => true,
        ]);

        $group2 = Group::create([
            'name' => 'Group Tahfidz Juz Amma',
            'description' => 'Group untuk menghafal Juz Amma (surah-surah terakhir)',
            'admin_id' => $admin->id,
            'code' => 'JUZAMMA',
            'is_active' => true,
        ]);

        // Create santri profiles
        $santri1 = Santri::create([
            'user_id' => $user1->id,
            'name' => 'Ahmad Santri',
            'email' => 'ahmad@example.com',
            'phone' => '081234567890',
            'birth_date' => '2000-01-15',
            'gender' => 'male',
            'address' => 'Jl. Merdeka No. 123, Jakarta',
            'is_active' => true,
        ]);

        $santri2 = Santri::create([
            'user_id' => $user2->id,
            'name' => 'Fatimah Santri',
            'email' => 'fatimah@example.com',
            'phone' => '081234567891',
            'birth_date' => '2001-03-20',
            'gender' => 'female',
            'address' => 'Jl. Sudirman No. 456, Jakarta',
            'is_active' => true,
        ]);

        // Add santris to groups
        GroupMember::create([
            'group_id' => $group1->id,
            'santri_id' => $santri1->id,
            'role' => 'member',
            'joined_at' => now()->subDays(30),
            'is_active' => true,
        ]);

        GroupMember::create([
            'group_id' => $group1->id,
            'santri_id' => $santri2->id,
            'role' => 'member',
            'joined_at' => now()->subDays(25),
            'is_active' => true,
        ]);

        GroupMember::create([
            'group_id' => $group2->id,
            'santri_id' => $santri1->id,
            'role' => 'member',
            'joined_at' => now()->subDays(20),
            'is_active' => true,
        ]);

        // Create sample hafalans
        Hafalan::create([
            'santri_id' => $santri1->id,
            'group_id' => $group1->id,
            'surah_name' => 'Al-Fatihah',
            'start_ayah' => 1,
            'end_ayah' => 7,
            'status' => 'completed',
            'target_date' => now()->subDays(5),
            'completed_date' => now()->subDays(3),
            'notes' => 'Hafalan lancar, perlu perbaikan tajwid',
            'score' => 85,
            'feedback' => 'Bagus, terus tingkatkan kualitas bacaan',
        ]);

        Hafalan::create([
            'santri_id' => $santri1->id,
            'group_id' => $group1->id,
            'surah_name' => 'Al-Ikhlas',
            'start_ayah' => 1,
            'end_ayah' => 4,
            'status' => 'pending',
            'target_date' => now()->addDays(3),
            'notes' => 'Target hafalan untuk minggu depan',
        ]);

        Hafalan::create([
            'santri_id' => $santri2->id,
            'group_id' => $group1->id,
            'surah_name' => 'Al-Fatihah',
            'start_ayah' => 1,
            'end_ayah' => 7,
            'status' => 'completed',
            'target_date' => now()->subDays(7),
            'completed_date' => now()->subDays(5),
            'notes' => 'Hafalan sangat baik',
            'score' => 95,
            'feedback' => 'Excellent! Hafalan sangat lancar dan tajwid sudah baik',
        ]);

        Hafalan::create([
            'santri_id' => $santri2->id,
            'group_id' => $group1->id,
            'surah_name' => 'An-Nas',
            'start_ayah' => 1,
            'end_ayah' => 6,
            'status' => 'pending',
            'target_date' => now()->addDays(2),
            'notes' => 'Fokus pada ayat terakhir',
        ]);

        // Create sample murajaahs
        Murajaah::create([
            'santri_id' => $santri1->id,
            'group_id' => $group1->id,
            'surah_name' => 'Al-Fatihah',
            'start_ayah' => 1,
            'end_ayah' => 7,
            'status' => 'completed',
            'target_date' => now()->subDays(2),
            'completed_date' => now()->subDays(1),
            'notes' => 'Murajaah untuk menjaga hafalan',
            'score' => 90,
            'feedback' => 'Murajaah lancar, hafalan masih kuat',
        ]);

        Murajaah::create([
            'santri_id' => $santri1->id,
            'group_id' => $group1->id,
            'surah_name' => 'Al-Ikhlas',
            'start_ayah' => 1,
            'end_ayah' => 4,
            'status' => 'pending',
            'target_date' => now()->addDays(1),
            'notes' => 'Murajaah rutin mingguan',
        ]);

        Murajaah::create([
            'santri_id' => $santri2->id,
            'group_id' => $group1->id,
            'surah_name' => 'Al-Fatihah',
            'start_ayah' => 1,
            'end_ayah' => 7,
            'status' => 'completed',
            'target_date' => now()->subDays(1),
            'completed_date' => now(),
            'notes' => 'Murajaah untuk persiapan ujian',
            'score' => 95,
            'feedback' => 'Sangat baik, siap untuk ujian',
        ]);

        Murajaah::create([
            'santri_id' => $santri2->id,
            'group_id' => $group1->id,
            'surah_name' => 'An-Nas',
            'start_ayah' => 1,
            'end_ayah' => 6,
            'status' => 'pending',
            'target_date' => now()->addDays(1),
            'notes' => 'Murajaah sebelum hafalan baru',
        ]);

        $this->command->info('Sample data created successfully!');
        $this->command->info('Admin Login: admin@qurantracker.com / password');
        $this->command->info('Santri 1 Login: ahmad@example.com / password');
        $this->command->info('Santri 2 Login: fatimah@example.com / password');
    }
}