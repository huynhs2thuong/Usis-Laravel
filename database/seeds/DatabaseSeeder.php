<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users')->count() === 0) {
            DB::table('users')->insert([
                'name' => 'admin',
                'email' => 'test@gmail.com',
                'password' => bcrypt('123456'),
                'level' => 'admin'
            ]);
        }
        Auth::login(\App\User::first());
        $this->call(FormsTableSeeder::class);
    }
}
