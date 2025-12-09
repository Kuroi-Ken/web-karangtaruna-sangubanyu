<?php
// app/Models/Image.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'filename',
        'path',
        'description',
        'is_active',
        'is_hero',  // TAMBAHKAN INI
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_hero' => 'boolean',  // TAMBAHKAN INI
    ];
}