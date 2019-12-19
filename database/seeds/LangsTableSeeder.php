<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LangsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('langs')->insert([
            'name' => 'Turkish',
            'slug' => 'turkish',
            'short_name' => 'tr',
            'entrycount' => '0',
        ]);
        DB::table('langs')->insert([
            'name' => 'English',
            'slug' => 'english',
            'short_name' => 'en',
            'entrycount' => '0',
        ]);
    }
}
