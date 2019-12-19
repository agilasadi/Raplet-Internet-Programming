<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserprofileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'anonymous',
            'email' => 'anonymous@anonymous.com',
            'password' => bcrypt('s8a9d7as897dasd89a'),
            'verify' => '0'
        ]);
        DB::table('userprofiles')->insert([
            'name' => 'anonymous',
            'bio' => '0',
            'slug' => 'anonymous',
            'user_id' => '1',
            'lang_id' => '1'
        ]);
        DB::table('userstats')->insert([
            'user_id' => '1',
        ]);


        DB::table('users')->insert([
            'name' => 'agil',
            'email' => 'agil@gmail.com',
            'password' => bcrypt('password'),
            'verify' => '0'
        ]);
        DB::table('userprofiles')->insert([
            'name' => 'agil',
            'bio' => '0',
            'slug' => 'agil',
            'user_id' => '2',
            'lang_id' => '1',
            'role_id' => '1'
        ]);
        DB::table('userstats')->insert([
            'user_id' => '2',
        ]);


        DB::table('users')->insert([
            'name' => 'aykut',
            'email' => 'aykut@gmail.com',
            'password' => bcrypt('password'),
            'verify' => '0'
        ]);
        DB::table('userprofiles')->insert([
            'name' => 'aykut',
            'bio' => '0',
            'slug' => 'aykut',
            'user_id' => '3',
            'lang_id' => '1',
            'role_id' => '1'
        ]);
        DB::table('userstats')->insert([
            'user_id' => '3',
        ]);


    }
}
