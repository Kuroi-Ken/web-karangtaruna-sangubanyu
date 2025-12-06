<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat admin user saja
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);

        // Buat categories dan posts dengan author admin
        $categories = Category::factory(4)->create();

        Post::factory(100)->recycle([
            $admin,
            $categories
        ])->create();
    }
}