<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder {
    public function run(): void {
        DB::table('users')->insert( [
            [
                'username' => 'user1@test.com',
                'password' => bcrypt('abc123456'),
                'created_at' => Date('Y-m-d H:i:s')
            ],
            [
                'username' => 'user2@test.com',
                'password' => bcrypt('abc123456'),
                'created_at' => Date('Y-m-d H:i:s')
            ],
            [
                'username' => 'user3@test.com',
                'password' => bcrypt('abc123456'),
                'created_at' => Date('Y-m-d H:i:s')
            ]
        ]);
    }
}
