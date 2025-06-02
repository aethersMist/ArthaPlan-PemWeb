<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    protected $fillable = ['type', 'category', 'amount', 'description', 'transaction_date'];
protected $casts = [
    'transaction_date' => 'date',
];

}
