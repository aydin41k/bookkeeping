<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    protected $fillable = ['company_id','date','amount','payment_method','notes','user_id'];

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }
}
