<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
	$title = $faker->words(3, true);
    return [
        'title' => [
            'vi' => $title,
            'en' => $title
        ],
        'slug' => str_slug($title),
        'description' => [
            'vi' => $faker->text(100),
            'en' => $faker->text(100)
        ],
        'resource_id' => App\Resource::orderByRaw('RAND()')->first()->id,
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
	$title = $faker->words(7, true);
    return [
        'title' => [
            'vi' => $title,
            'en' => $title
        ],
        'slug' => str_slug($title),
        'description' => [
            'vi' => $faker->text(200),
            'en' => $faker->text(200)
        ],
        'excerpt' => [
            'vi' => $faker->text(20),
            'en' => $faker->text(20)
        ],
        'resource_id' => App\Resource::orderByRaw('RAND()')->first()->id,
    ];
});

$factory->define(App\Group::class, function (Faker\Generator $faker) {
    $title = $faker->words(3, true);
    return [
        'title' => [
            'vi' => $title,
            'en' => $title
        ],
        'slug' => str_slug($title),
        'is_side' => 0,
        'change_size' => '',
        'change_col' => '',
        'description' => [
            'vi' => $faker->text(100),
            'en' => $faker->text(100)
        ],
        'resource_id' => App\Resource::orderByRaw('RAND()')->first()->id,
    ];
});

$factory->define(App\Dish::class, function (Faker\Generator $faker) {
    return [
        'title' => [
            'vi' => $faker->words(7, true),
            'en' => $faker->words(7, true)
        ],
        'product_id' => $faker->randomNumber(7),
        'price' => (int) $faker->numerify('##000'),
        'discount' => rand(10, 50),
        'combo' => [],
        'resource_id' => App\Resource::orderByRaw('RAND()')->first()->id,
    ];
});

$factory->define(App\Page::class, function (Faker\Generator $faker) {
    $title = $faker->words(7, true);
    return [
        'title' => [
            'vi' => $title,
            'en' => $title
        ],
        'slug' => str_slug($title),
        'template' => '',
        'description' => [
            'vi' => $faker->text(200),
            'en' => $faker->text(200)
        ],
        'resource_id' => App\Resource::orderByRaw('RAND()')->first()->id,
    ];
});

$factory->define(App\Store::class, function (Faker\Generator $faker) {
    return [
        'title' => [
            'vi' => 'Jollibee ' . $faker->words(2, true),
            'en' => 'Jollibee ' . $faker->words(2, true)
        ],
        'address' => [
            'vi' => $faker->words(10, true),
            'en' => $faker->words(10, true)
        ],
        'district_id' => App\District::orderByRaw('RAND()')->first()->id,
        'business_hours' => '7:00 AM - 9:00 PM',
        'phone' => $faker->numerify('(08) #### ####'),
        'lat' => '10.7883447',
        'lng' => '106.6955799',
        'resource_id' => App\Resource::orderByRaw('RAND()')->first()->id,
    ];
});

$factory->define(App\Contact::class, function (Faker\Generator $faker) {
    $fakerVi = Faker\Factory::create('vi_VN');
    return [
        'name' => $fakerVi->name,
        'email' => $fakerVi->safeEmail,
        'phone' => $fakerVi->phoneNumber,
        'message' => $fakerVi->words(20, true)
    ];
});
