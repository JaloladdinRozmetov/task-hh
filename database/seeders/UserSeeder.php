<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jaloladdin',
            'email' => 'jalolabek@email.com',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
