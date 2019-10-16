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
      DB::table('categories')->insert([
          ['category_name' => 'room'],
          ['category_name' => 'monster'],
          ['category_name' => 'visual'],

        ]);
    }
}
