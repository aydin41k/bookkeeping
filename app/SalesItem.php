<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    protected $fillable = ['name','multiplier','default_price'];
	public $timestamps = false;

	public function invoices()
	{
    	return $this->belongsToMany('App\SalesInvoice','sales_invoice_items','sales_item_id','sales_invoice_id');
	}
}
