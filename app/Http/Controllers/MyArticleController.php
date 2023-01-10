<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyArticleController extends Controller
{
    
    public function index()
    {
        return view("pages.frontend.myarticle.index");
    }

}
