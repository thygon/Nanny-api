<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->roles();
    }

    public function roles(){
    	DB::table('roles')->insert([
           'role' => 'nany'
        ]);
        DB::table('roles')->insert([
           'role' => 'mama'
        ]);

        DB::table('admins')->insert([
           'name' => 'administrator',
           'email' => 'admin@gmail.com',
           'password'=>bcrypt('password'),
           'online'=>false
        ]);
        return response()->json('Seeded Successful');
    }
}
