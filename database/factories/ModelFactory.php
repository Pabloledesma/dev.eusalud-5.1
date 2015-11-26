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
		'name'    => $faker->sentence,
		'label'   => $faker->sentence
	];
});

$factory->define(App\Permission::class, function($faker){
    return [
        'name'     => $faker->sentence,
        'label'    => $faker->word
    ];
});
