<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    
    public function create()
    {
        return view("pages.frontend.transaction.create");
    }

    public function show()
    {
        return view("pages.frontend.transaction.detail");
    }

}
