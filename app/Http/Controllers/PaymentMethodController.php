<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function getList()
    {
    	return [
    				'', // Keep this blank, will populate 'Please select' here for <select>
    				'Cash',
    				'Cheque',
    				'Bank Transfer'
    				];
    }
}
