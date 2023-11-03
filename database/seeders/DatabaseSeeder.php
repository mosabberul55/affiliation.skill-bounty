<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminUser = [
            'name' => 'Admin',
            'phone' => '01761312652',
            'role' => 'admin',
            'code' => '123456'
        ];
        \App\Models\User::create($adminUser);
        $users = \App\Models\User::factory(10)->create();
        $users->each(function ($user) {
            $user->incomes()->saveMany(\App\Models\Income::factory(10)->make());
            $user->withdraws()->saveMany(\App\Models\Withdraw::factory(10)->make());
        });

    }
}
