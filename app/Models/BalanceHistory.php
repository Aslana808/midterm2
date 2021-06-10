<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'added_amount',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
