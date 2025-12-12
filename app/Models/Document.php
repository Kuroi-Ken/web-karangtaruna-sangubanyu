<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'description',
        'category',
        'is_published',
        'order'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'file_size' => 'integer',
    ];

    // Accessor untuk format file size
    public function getFormattedFileSizeAttribute(): string
    {
        $size = $this->file_size;
        
        if ($size < 1024) {
            return $size . ' B';
        } elseif ($size < 1048576) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return number_format($size / 1048576, 2) . ' MB';
        }
    }

    // Scope untuk filter published
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}