<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'profile_id',
        'comment'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}