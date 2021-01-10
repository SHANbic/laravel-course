<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home() {
        // dd(Auth::check()); checks if a user is authenticated
        return view('home');
    }

    public function contact() {
        return view('contact');
    }

    public function secret() {
        return view('secret');
    }
}
