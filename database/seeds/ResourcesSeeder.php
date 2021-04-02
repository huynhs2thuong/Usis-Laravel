<?php

use Illuminate\Database\Seeder;

class ResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resources')->delete();
        DB::statement('ALTER TABLE resources AUTO_INCREMENT = 1;');
        for ($i = 0; $i < 10; $i++) {
            $fileName = 'image-' . $i . '.jpg';
            $image = file_get_contents('http://unsplash.it/1280/720?random');
            file_put_contents(public_path('uploads' . DIRECTORY_SEPARATOR . 'post' . DIRECTORY_SEPARATOR) . $fileName, $image);

            App\Resource::create([
				'type' => 'post',
				'name' => $fileName
            ]);
        }
    }
}
