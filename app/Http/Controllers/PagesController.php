<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function root()
    {
        //dd(config('my.KEVIN'));
        return view('pages.root');
    }
}
