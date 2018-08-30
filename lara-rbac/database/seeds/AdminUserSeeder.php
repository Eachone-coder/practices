<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection('admin_users')->insert([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('admin')
        ]);
    }
}
