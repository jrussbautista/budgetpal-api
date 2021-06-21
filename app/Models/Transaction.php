<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['amount', 'category_id', 'type', 'title',  'happened_on'];

    public function getAmountAttribute() {
        return $this->attributes['amount'] / 100;
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }


}
