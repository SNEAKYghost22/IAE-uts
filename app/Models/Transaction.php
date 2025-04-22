<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'sender_account_id',
        'receiver_account_id',
        'amount',
        'status',
    ];
}
