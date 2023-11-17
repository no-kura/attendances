<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => '長野',
            'email' => 'nagano@nagano.com',
            'password' => 'password'
        ]);
        DB::table('users')->insert([
            'name' => '秋田',
            'email' => 'akita@akita.com',
            'password' => 'password'
        ]);
        DB::table('users')->insert([
            'name' => '熊木',
            'email' => 'kumaki@kumaki.com',
            'password' => 'password'
        ]);
    }
}
