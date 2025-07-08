<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    public function user()
{
    return $this->belongsTo(User::class);
}

    protected $fillable = [
        'name',
        'category_id',
        'date',
        'amount',
        'note',
        'image',
        'user_id',
    ];

        public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeExpenses($query)
    {
        return $query->WhereHas('category', function ($query){
            $query->where('is_expense', true);
        });
    }
    
    public function scopeInComes($query)
    {
        return $query->WhereHas('category', function ($query){
            $query->where('is_expense', false);
        });
    }
    
}
