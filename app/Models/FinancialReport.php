<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'report_type',
        'year',
        'month',
        'quarter',
        'income',
        'expense',
        'balance',
        'description',
        'file_path',
        'is_published',
        'order'
    ];

    protected $casts = [
        'income' => 'decimal:2',
        'expense' => 'decimal:2',
        'balance' => 'decimal:2',
        'is_published' => 'boolean',
        'year' => 'integer',
        'month' => 'integer',
        'quarter' => 'integer',
    ];

    // Accessor untuk format periode
    public function getPeriodAttribute(): string
    {
        if ($this->report_type === 'monthly') {
            return date('F', mktime(0, 0, 0, $this->month, 1)) . ' ' . $this->year;
        } elseif ($this->report_type === 'quarterly') {
            return 'Q' . $this->quarter . ' ' . $this->year;
        } else {
            return 'Tahun ' . $this->year;
        }
    }

    // Accessor untuk format currency
    public function getFormattedIncomeAttribute(): string
    {
        return 'Rp ' . number_format($this->income, 0, ',', '.');
    }

    public function getFormattedExpenseAttribute(): string
    {
        return 'Rp ' . number_format($this->expense, 0, ',', '.');
    }

    public function getFormattedBalanceAttribute(): string
    {
        return 'Rp ' . number_format($this->balance, 0, ',', '.');
    }

    // Scope untuk filter berdasarkan tipe
    public function scopeMonthly($query)
    {
        return $query->where('report_type', 'monthly');
    }

    public function scopeQuarterly($query)
    {
        return $query->where('report_type', 'quarterly');
    }

    public function scopeYearly($query)
    {
        return $query->where('report_type', 'yearly');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}