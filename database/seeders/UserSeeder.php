<?php

namespace Database\Seeders;

use App\Models\DetailUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seller = User::create([
            'name' => 'Dummy Seller',
            'email' => 'seller@mail.com',
            'password' => Hash::make('password'),
        ]);

        DetailUser::create([
            'user_id' => $seller->id,
            'phone' => '6281234567890',
            'address' => 'Sleman, Yogyakarta',
            'role' => 'seller',
        ]);

        $customer = User::create([
            'name' => 'Dummy Customer',
            'email' => 'customer@mail.com',
            'password' => Hash::make('password'),
        ]);

        DetailUser::create([
            'user_id' => $customer->id,
            'phone' => '6289012345678',
            'address' => 'Bantul, Yogyakarta',
            'role' => 'user',
        ]);
    }
}