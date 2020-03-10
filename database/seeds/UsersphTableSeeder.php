<?php

use Illuminate\Database\Seeder;

class UsersphTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		factory(\App\Userspb::class, 100)->create();
    }
}
