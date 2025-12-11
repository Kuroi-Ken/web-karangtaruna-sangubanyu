<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    
    protected $table = 'about';
    
    protected $fillable = [
        'title',
        'description',
        'vision',
        'mission',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'mission' => 'array', // Cast JSON to array
    ];
}