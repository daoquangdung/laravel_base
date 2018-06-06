<?php

use Illuminate\Database\Seeder;
use App\Model\TbUsers;

class TbUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = TbUsers::create([
            'username' => 'admin',
            'email' =>'admin@gmail.com',
            'password' => Hash::make('admin')
        ]);
    }
}
