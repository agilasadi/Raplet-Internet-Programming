<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ranks')->insert([
            'name' => 'admin',
            'slug' => 'admin',
            'replimit' => '4000000',
            'define_id' => '0',
        ]);
        DB::table('ranks')->insert([
            'name' => 'moderator',
            'slug' => 'moderator',
            'replimit' => '2000000',
            'define_id' => '0',
        ]);
        DB::table('ranks')->insert([
            'name' => 'Admin Panel Admin',
            'slug' => 'adminpaneladmin',
            'replimit' => '999999999',
            'define_id' => '0',
        ]);
        DB::table('ranks')->insert([
            'name' => 'Regular User',
            'slug' => 'regularuser',
            'replimit' => '0',
            'define_id' => '0',
        ]);
    }
}
