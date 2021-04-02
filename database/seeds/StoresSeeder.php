<?php

use Illuminate\Database\Seeder;

class StoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->delete();
        DB::statement('ALTER TABLE cities AUTO_INCREMENT = 1;');
        DB::statement('ALTER TABLE districts AUTO_INCREMENT = 1;');
        DB::unprepared(file_get_contents(database_path()."/seeds/cities.sql"));
        DB::unprepared(file_get_contents(database_path()."/seeds/districts.sql"));

        Cache::forget('cities');
        Cache::forget('districts');

        DB::table('stores')->delete();
        DB::statement('ALTER TABLE stores AUTO_INCREMENT = 1;');

        Auth::login(\App\User::first());
        factory(App\Store::class, 20)->create();
    }
}
