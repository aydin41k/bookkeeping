<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    protected $fillable = ['invoice_no','company_id','invoice_date','amount','delivery_date','delivered_by','user_id'];

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }
    public function items()
    {
    	return $this->hasMany('App\PurchaseInvoiceItem','invoice_id','id');
    }
}
