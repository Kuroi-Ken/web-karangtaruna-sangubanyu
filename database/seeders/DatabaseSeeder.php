<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\StructurePosition;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         $positions = [
            ['position' => 'Ketua', 'name' => 'Ahmad Rifai', 'phone' => '081234567890', 'order' => 0],
            ['position' => 'Wakil Ketua', 'name' => 'Budi Santoso', 'phone' => '081234567891', 'order' => 1],
            ['position' => 'Sekretaris', 'name' => 'Citra Dewi', 'phone' => '081234567892', 'order' => 2],
            ['position' => 'Bendahara', 'name' => 'Dani Prasetyo', 'phone' => '081234567893', 'order' => 3],
            ['position' => 'Seksi Humas', 'name' => 'Eka Putri', 'phone' => '081234567894', 'order' => 4],
            ['position' => 'Seksi Acara', 'name' => 'Fahmi Rahman', 'phone' => '081234567895', 'order' => 5],
        ];

        foreach ($positions as $position) {
            StructurePosition::create($position);
        }
        // Buat admin user
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);

        // Buat categories secara berurutan
        $categoryNames = [
            'Kegiatan Dusun Krajan', 
            'Kegiatan Dusun Ketundan', 
            'Kegiatan Dusun Telogosirih',
            'Kegiatan Dusun Karang Lor', 
            'Kegiatan Dusun Karang Kidul', 
            'Kegiatan Dusun Nampu'];
        $categories = [];
        
        foreach ($categoryNames as $name) {
            $categories[] = Category::create([
                'activity' => $name,
                'slug' => Str::slug($name)
            ]);
        }

        // Buat 50 posts dengan fake data
        foreach (range(1, 50) as $index) {
            Post::create([
                'title' => fake()->sentence(rand(5, 12)), // Judul random 5-12 kata
                'author_id' => $admin->id,
                'author_name' => fake()->name(), // Nama author random dari Faker
                'cate_id' => fake()->randomElement($categories)->id,
                'body' => fake()->paragraphs(rand(4, 10), true), // 4-10 paragraf
            ]);
        }
    }
}