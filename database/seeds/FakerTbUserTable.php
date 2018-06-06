<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Model\TbUsers;
class FakerTbUserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        for ($i = 0;$i<=100;$i++){
            $user = TbUsers::create([
                'name' => $faker->userName,
                'email' =>$faker->email,
                'password' => Hash::make('123456')
            ]);
        }
    }
}
