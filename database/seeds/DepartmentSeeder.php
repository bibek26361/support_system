<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'departmentname' => 'NCT Support',
            'contact' => '071-537167',
            'contact_network'=>'NTC',
            'code' => 'nct-support',
            'status' => 1,
        ]);

        DB::table('departments')->insert([
            'departmentname' => 'RestroMS Support',
            'contact' => '9802627682',
            'contact_network'=>'NCELL',
            'code' => 'restroms-support',
            'status' => 1,
        ]);

        DB::table('departments')->insert([
            'departmentname' => 'Hardware Support',
            'contact' => '9802627683',
            'contact_network'=>'NCELL',
            'code' => 'hardware-support',
            'status' => 1,
        ]);
    }
}
