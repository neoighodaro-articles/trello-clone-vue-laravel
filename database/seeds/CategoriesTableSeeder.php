<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
        	['name' => "Ideas"],
        	['name' => "On Going"],
        	['name' => "Completed"]
        ];

        foreach ($categories as $category) 
        {
        	\App\Category::create($category);
        }
    }
}
