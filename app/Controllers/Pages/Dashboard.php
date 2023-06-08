<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function __construct()
    {
        session()->remove('active_menu_id');
    }

    public function index()
    {
        if (auth()->loggedIn()) {
            return view('Pages/dashboard');
        }
        return view('homepage');
    }
}
