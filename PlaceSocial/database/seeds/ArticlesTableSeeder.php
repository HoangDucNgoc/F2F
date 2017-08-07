<?php

use Illuminate\Database\Seeder;
use App\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::truncate();

        $seed = \Faker\Factory::create();

        for($i = 0; $i < 50; $i++)
        {
        	Article::create([
        		'title' => $seed->sentence,
        		'body' => $seed->paragraph,
        	]);
        }
    }
}
