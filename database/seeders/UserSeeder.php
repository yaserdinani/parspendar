<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'name' => 'yaserdinani',
            'phone'=>'09130616299',
            'email' => 'yaserdinani@gmail.com',
            'password' => Hash::make('1234'),
            'is_admin' => true
        ]);
        User::create([
            'name' => 'first',
            'phone'=>'09130616298',
            'email' => 'first@gmail.com',
            'password' => Hash::make('1111'),
        ]);
        User::create([
            'name' => 'second',
            'phone'=>'09130616297',
            'email' => 'second@gmail.com',
            'password' => Hash::make('2222'),
        ]);
        User::create([
            'name' => 'third',
            'phone'=>'09130616296',
            'email' => 'third@gmail.com',
            'password' => Hash::make('3333'),
        ]);
    }
}
