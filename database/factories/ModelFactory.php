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

$factory->define(App\User::class, function ($faker) {
    
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('123456'),
        'num_id'	=> mt_rand(),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Role::class, function($faker){
	return [
		'role_title' => $faker->sentence,
		'role_slug' => $faker->word
	];
});

$factory->define(App\Permission::class, function($faker){
    return [
        'permission_title'      => $faker->sentence,
        'permission_slug'       => $faker->word,
        'permission_description'=> $faker->paragraph
    ];
});
