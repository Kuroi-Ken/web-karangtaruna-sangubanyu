<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $test = User:: create([
            'name' => 'Faiz Nur Ramadhan',
            'username' =>'KuroiKen',
            'email' => 'faizamadhan@hotmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token'=> Str::random(10)
            
        ]);

        $users = User::factory(5)->create();
        $categories = Category::factory(4)->create();


        Post::factory(100)->recycle([
            $test,
            $users,
            $categories
        ])->create();
    }
}