<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role'     => 'admin',
            'name'     => 'Admin',
            'email'    => 'hoydigo.com@gmail.com',
            'password' => '$2y$10$dmQmyyu./5uEb.Ti/ZeO3e80V8.mbivA4K1b43O9yvjWbvff0J7qK',
        ]);
    }
}
