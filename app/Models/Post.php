<?php
// app/Models/Post.php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = ['author_id', 'author_name', 'title', 'body', 'cate_id'];
    protected $with = ['category', 'author'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }
    
    // Accessor untuk mendapatkan nama author (prioritas author_name, fallback ke author->name)
    public function getAuthorDisplayAttribute(): string
    {
        return $this->author_name ?? $this->author->name ?? 'Unknown';
    }
}