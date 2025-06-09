<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{

    static $categories = [
		'легкий', 
		'хрупкий', 
		'тяжелый',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$categories as $name) {
            DB::table('categories')->insert([
                'name' => $name,
            ]);
        }
    }
}
