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
    
	$user_type = ['Super Admin', 'User', 'Administrator', 'Provider'];

    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'num_id'	=> rand(),
        'user_type' => $user_type[rand(0, 3)],
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
        'permission_title' => $faker->sentence,
        'permission_slug' => $faker->word,
    ];
});
