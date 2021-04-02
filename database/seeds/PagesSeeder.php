<?php

use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('pages')->delete();
		DB::statement('ALTER TABLE pages AUTO_INCREMENT = 1;');
		//Auth::login(\App\User::first());
    	//factory(App\Page::class, 1)->create();
        DB::unprepared(file_get_contents(database_path()."/seeds/pages.sql"));
    }
}
