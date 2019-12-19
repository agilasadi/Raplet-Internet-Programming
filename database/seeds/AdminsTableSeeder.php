<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'raplet',
            'email' => 'newsma.95@gmail.com',
            'password' => bcrypt('asar55soft77ware'),
            'role' => 'admin',
        ]);
    }
}
