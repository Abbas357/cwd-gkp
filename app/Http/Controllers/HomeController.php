<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function dashboard()
    {
        return view('backend.home');
    }
}
