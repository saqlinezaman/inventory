<?php

namespace App\Http\Controllers;
use GuzzleHttp\Psr7\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home');
    }
     public function about()
    {
        return Inertia::render('about');
    }
}
