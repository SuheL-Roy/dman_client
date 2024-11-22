<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function about()
    {
        return view('frontend_new.about');
    }
    public function services()
    {
        # code...
        return view('frontend_new.service');
    }
    public function price()
    {
        # code...
        return view('frontend_new.price');
    }
    public function contact()
    {
        # code...
        return view('frontend_new.contact');
    }
}
