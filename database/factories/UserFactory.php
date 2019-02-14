<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        // 'name' => $faker->name,
        // 'apellido_p' => $faker->apellido_p,
        // 'apellido_m' => $faker->apellido_m,
        // 'email' => $faker->unique()->safeEmail,
        // 'email_verified_at' => now(),
        // 'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        // 'fecha_nac' => $faker->fecha_nac,
        // 'telefono' => $faker->telefono,
        // 'peso' => $faker->peso,
        // 'estatura' => $faker->estatura,
        // 'n_clases' => $faker->n_clases,
        // 'genero' => $faker->genero,
        // 'expiracion' => $faker->expiracion,
        // 'remember_token' => str_random(10),

        //Renamed variables translated in english
        'name' => $faker->name,
        'last_name' => $faker->last_name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'birth_date' => $faker->birth_date,
        'phone' => $faker->phone,
        'weight' => $faker->weight,
        'height' => $faker->height,
        'gender' => $faker->gender,
        'remember_token' => str_random(10),
    ];
});
