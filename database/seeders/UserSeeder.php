<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pegawai = User::create([
            'name' => 'pegawai',
            'email' => 'febrybundaaffa@gmail.com',
            'password' => bcrypt('a'),
        ]);
        $pegawai->assignRole('pegawai');

        $opd = User::create([
            'name' => 'BKPPD',
            'email' => 'bkppd.pekalongankota@gmail.com',
            'password' => bcrypt('a'),
        ]);
        $opd->assignRole('opd');

        $admin = User::create([
            'name' => 'admin',
            'email' => 'goentursumkid@gmail.com',
            'password' => bcrypt('a'),
        ]);
        $admin->assignRole('admin');
    }
}
