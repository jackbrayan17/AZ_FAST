<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function dashboard()
    {
        return view('merchant.dashboard'); // Create a view for the merchant dashboard
    }
}
