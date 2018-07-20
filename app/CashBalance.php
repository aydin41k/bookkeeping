<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashBalance extends Model
{
    protected $fillable = ['date','amount','counted_by'];
}
