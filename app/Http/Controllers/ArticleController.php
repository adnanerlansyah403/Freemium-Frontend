<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    
    public function show()
    {
        return view("pages.frontend.article.detail");
    }

    public function create()
    {
        return view("pages.frontend.article.create");
    }

    public function edit()
    {
        return view("pages.frontend.article.edit");
    }

}
