<?php

use Illuminate\Database\Seeder;

class DishesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->delete();
    	DB::table('dishes')->delete();
		DB::statement('ALTER TABLE groups AUTO_INCREMENT = 1;');
		DB::statement('ALTER TABLE dishes AUTO_INCREMENT = 1;');
    	factory(App\Group::class, 10)->create()->each(function($group) {
	        $group->dishes()->saveMany(factory(App\Dish::class, 10)->make());
	    });
    }
}
