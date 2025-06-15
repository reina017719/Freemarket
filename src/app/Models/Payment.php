<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'payment_id',
    ];

    public function item()
    {
        return $this->belongsToMany(Item::class);
    }
}