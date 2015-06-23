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
    
    $user_type = ['Super Admin', 'User', 'Admin', 'Provider'];

    return [
        'name' 		=> $faker->name,
        'email' 	=> $faker->email,
        'password' 	=> str_random(10),
        'num_id'	=> mt_rand(),
        'user_type' => $user_type[mt_rand(0, 3)],
        'remember_token' => str_random(10),
    ];
});
