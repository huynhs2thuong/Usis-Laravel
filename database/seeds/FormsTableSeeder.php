<?php

use Illuminate\Database\Seeder;

class FormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forms')->insert([
            'title' => 'Faq Form',
            'data' => '[{"name":"name","require":true,"type":"string"},{"name":"email","require":true,"type":"email"},{"name":"tel","require":false,"type":"tel"},{"name":"add","require":true,"type":"string"},{"name":"content","require":true,"type":"string"}]'
        ]);
        DB::table('forms')->insert([
            'title' => 'Agency Form',
            'data' => '[{"name":"name","require":true,"type":"string"},{"name":"email","require":true,"type":"email"},{"name":"tel","require":false,"type":"tel"},{"name":"add","require":true,"type":"string"},{"name":"content","require":true,"type":"string"}]'
        ]);
        DB::table('forms')->insert([
            'title' => 'Color Form',
            'data' => '[{"name":"name","require":true,"type":"string"},{"name":"email","require":true,"type":"email"},{"name":"tel","require":false,"type":"tel"},{"name":"add","require":true,"type":"string"},{"name":"city","require":true,"type":"string"},{"name":"district","require":true,"type":"string"}]'
        ]);
        DB::table('forms')->insert([
            'title' => 'Color Form',
            'data' => '[{"name":"name","require":true,"type":"string"},{"name":"email","require":true,"type":"email"},{"name":"tel","require":false,"type":"tel"},{"name":"add","require":true,"type":"string"},{"name":"city","require":true,"type":"string"},{"name":"district","require":true,"type":"string"}]'
        ]);
        DB::table('forms')->insert([
            'title' => 'Contact Form',
            'data' => '[{"name":"name","require":true,"type":"string"},{"name":"email","require":true,"type":"email"},{"name":"tel","require":false,"type":"tel"},{"name":"add","require":true,"type":"string"},{"name":"content","require":true,"type":"string"}]'
        ]);
        DB::table('forms')->insert([
            'title' => 'Promo Form',
            'data' => '[{"name":"name","require":true,"type":"string"},{"name":"email","require":true,"type":"email"},{"name":"tel","require":false,"type":"tel"},{"name":"job","require":true,"type":"string"},{"name":"content","require":true,"type":"string"}]'
        ]);
    }
}
