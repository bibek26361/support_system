<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'department_id' => 1,
            'name' => 'admin',
            'email' => 'admin@myself.com',
            'password' => bcrypt('ajakcha123'),
            'contact' => '071-537167',
        ]);
        
        DB::table('users')->insert([
            'department_id' => 2,
            'name' => 'Rahul Thapa',
            'email' => 'rahulthapa043@gmail.com',
            'password' => bcrypt('rahulthapa043'),
            'contact' => '9802627682',
        ]);
    }
}
