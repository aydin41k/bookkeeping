<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockCount extends Model
{
    protected $fillable = ['date','amount','counted_by'];
}
