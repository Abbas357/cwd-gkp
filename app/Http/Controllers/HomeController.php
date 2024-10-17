<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('site.index');
    }

    public function dashboard()
    {
        return view('admin.home');
    }
}
