<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function sample()
    {
        return view('pages.sample');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
