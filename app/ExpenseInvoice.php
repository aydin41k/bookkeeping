<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseInvoice extends Model
{
    protected $fillable = ['invoice_no','company_id','invoice_date','amount','user_id'];

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }
}
