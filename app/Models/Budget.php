<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable  = ['amount', 'category_id'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getAmountAttribute() {
        return $this->attributes['amount'] / 100;
    }

    public function getSpentAttribute() {
        $spent = auth()->user()
            ->transactions()
            ->where('category_id', $this->category_id)
            ->where('type', 'expense')
            ->sum('amount');
        return $spent / 100;
    }



}
