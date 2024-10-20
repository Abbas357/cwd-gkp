<?php

namespace App\Http\Controllers;

class HomePageController extends Controller
{
    public function site()
    {
        return view('site.home.index');
    }

    public function dashboard()
    {
        return view('admin.home.index');
    }

}
