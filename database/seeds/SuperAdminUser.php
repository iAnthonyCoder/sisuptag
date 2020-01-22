<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => "0",
            'name' => "Anthony",
            'email' => 'anthony@example.com',
            'password' => bcrypt('securepassword'),
            'is_admin' => "1",
        ]);
    }
}
