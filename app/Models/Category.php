<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
  
    protected $fillable = ['cate_title', 'status'];
    protected $table = 'categories';

    
    public function post(): HasMany{
      return $this->hasMany(Post::class, 'cate_id');
    }
}