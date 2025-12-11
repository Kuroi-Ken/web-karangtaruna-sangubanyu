<?php
// app/Models/Contact.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'type',
        'label',
        'value',
        'link',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope untuk filter berdasarkan tipe
    public function scopeWhatsapp($query)
    {
        return $query->where('type', 'whatsapp');
    }

    public function scopeInstagram($query)
    {
        return $query->where('type', 'instagram');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}