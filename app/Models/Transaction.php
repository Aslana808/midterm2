<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Transaction extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'sender_user_id',
        'recipient_user_id',
        'amount',
        'commission_amount'
    ];
}
