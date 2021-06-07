<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $fillable  = ['amount', 'category_id', 'start_date', 'end_date'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeByCategory($query, $category_id) {
        return $query->where('category_id', $category_id);
    }

    public function scopeByDates($query, $start_date, $end_date) {
        return $query->where('start_date', $start_date)
            ->where('end_date', $end_date);
    }

    public function scopeByOnGoing($query) {
        $today = Carbon::today();
        return $query->where('end_date', '>=', $today);
    }

    public function getSpentPercentageAttribute() {
        $value = ($this->amount_spent / $this->amount)  * 100;
        $result = round($value,  0);
       return $result > 100 ? '100%' : $result . '%';
    }

    public function getStatusAttribute() {
        $today = Carbon::today();
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', "{$this->end_date} 00:00:00");
        return $today->gt($end_date) ? 'finished' : 'on going';
    }

    public function getAmountAttribute() {
        return $this->attributes['amount'] / 100;
    }

    public function getAmountSpentAttribute() {
        $spent = auth()->user()
            ->transactions()
            ->where('category_id', $this->category_id)
            ->where('type', 'expense')
            ->whereBetween('happened_on', [$this->start_date, $this->end_date])
            ->sum('amount');
            
        return $spent / 100;
    }



}
