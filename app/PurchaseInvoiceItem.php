<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItem extends Model
{
    protected $fillable = ['invoice_id','item_id','qty','price'];
	public $timestamps = false;

	public function info()
	{
		return $this->hasOne('App\PurchaseItem','id','item_id');
	}
}
