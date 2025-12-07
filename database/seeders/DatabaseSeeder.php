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
        $categoryNames = ['Kegiatan Desa A', 'Kegiatan Desa B', 'Kegiatan Desa C', 'Kegiatan Desa D'];
        $categories = [];
        
        foreach ($categoryNames as $name) {
            $categories[] = Category::create([
                'activity' => $name,
                'slug' => Str::slug($name)
            ]);
        }
        // Post::factory(50)->recycle([
        //     $admin,
        //     $categories
        // ])->create();
    }
}