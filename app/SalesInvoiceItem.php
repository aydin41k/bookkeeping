<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesInvoiceItem extends Model
{
    protected $fillable = ['sales_invoice_id','sales_item_id','qty','price'];
	public $timestamps = false;

	public function info()
	{
		return $this->belongsTo('App\SalesItem','sales_item_id','id');
	}
}
