<?php

use Illuminate\Database\Seeder;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->delete();
        DB::statement('ALTER TABLE contacts AUTO_INCREMENT = 1;');

        factory(App\Contact::class, 20)->create();
    }
}
