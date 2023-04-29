<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
Use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        //单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'LCamel';
        $user->email = 'mamdy112889@qq.com';
        $user->save();
    }
}
