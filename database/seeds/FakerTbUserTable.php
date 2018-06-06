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
        for ($i = 0;$i<=10000;$i++){
            $email = $faker->email;
            $check = TbUsers::where('email', '=', $email)->first();
            if(!$check){
                $user = TbUsers::create([
                    'username' => $faker->userName,
                    'email' =>$email,
                    'password' => Hash::make('123456')
                ]);
            }

        }
    }
}
