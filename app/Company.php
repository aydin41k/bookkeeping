<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['abn','name','address','phone','email','contact_person'];

    public function salesinvoice() {
        return $this->hasMany('App\SalesInvoice');
    }
    public function purchaseinvoice() {
        return $this->hasMany('App\PurchaseInvoice');
    }
    public function collections()
    {
    	return $this->hasMany('App\SalesPayment');
    }
    public function payments()
    {
    	return $this->hasMany('App\PurchasePayment');
    }
}
