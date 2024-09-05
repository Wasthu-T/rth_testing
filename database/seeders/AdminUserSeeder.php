<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'uuid' => '000000000001',
            'username' => 'admindlh',
            'nm_lengkap' => 'Admin DLH',
            'alamat' => 'Dinas Lingkungan Hidup Kabupaten Bantul Komplek II Kantor Pemerintah Kabupaten Bantul Jl. Lingkar Timur, Manding, Bantul, Daerah Istimewa Yogyakarta',
            'no_hp' => '0895364399009',
            'email' => 'dlh@bantulkab.go.id',
            'password' => Hash::make('AdminDlh123*'), 
            'admin' => true,
            'akses_lvl' => '2',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'uuid' => '000000000002',
            'username' => 'adminuptd',
            'nm_lengkap' => 'Admin UPTDKPP',
            'alamat' => 'Dinas Lingkungan Hidup Kabupaten Bantul Komplek II Kantor Pemerintah Kabupaten Bantul Jl. Lingkar Timur, Manding, Bantul, Daerah Istimewa Yogyakarta',
            'no_hp' => '',
            'email' => '',
            'password' => Hash::make('AdminUptd123*'), 
            'admin' => true,
            'akses_lvl' => '1',
            'remember_token' => Str::random(10),
        ]);
    }
}
