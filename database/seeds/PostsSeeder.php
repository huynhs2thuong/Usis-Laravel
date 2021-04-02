<?php

use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('categories')->delete();
    	DB::table('posts')->delete();
		DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1;');
		DB::statement('ALTER TABLE posts AUTO_INCREMENT = 1;');
    	factory(App\Category::class, 5)->create()->each(function($category) {
	        $category->posts()->saveMany(factory(App\Post::class, 10)->make());
	    });
    }
}
