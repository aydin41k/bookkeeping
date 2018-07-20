<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    protected $fillable = ['company_id','invoice_date','amount','delivery_date','delivered_by','status','user_id'];

    public function company()
    {
    	return $this->belongsTo('App\Company')->orderBy('name');
    }

    public function items()
    {
    	return $this->hasMany('App\SalesInvoiceItem','sales_invoice_id','id');
    }
}
