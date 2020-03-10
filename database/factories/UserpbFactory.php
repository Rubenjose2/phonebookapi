<?php

	/** @var \Illuminate\Database\Eloquent\Factory $factory */

	use App\Userspb;
	use Faker\Generator as Faker;
	use Illuminate\Support\Str;

	$factory->define(Userspb::class, function (Faker $faker) {
		return [
			'fullName' 		=> ($faker->firstName . ' ' . $faker->lastName),
			'address' 		=> $faker->address,
			'phoneNumber' 	=> $faker->randomNumber(7),
			'email' 		=> $faker->email,
			'status' 		=> true
		];
	});