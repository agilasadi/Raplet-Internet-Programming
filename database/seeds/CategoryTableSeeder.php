<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            'name' => 'Technology',
            'slug' => 'technology',
        ]);
        DB::table('category')->insert([
            'name' => 'Education',
            'slug' => 'education',
        ]);
        DB::table('category')->insert([
            'name' => 'Culture',
            'slug' => 'culture',
        ]);
    }
}
