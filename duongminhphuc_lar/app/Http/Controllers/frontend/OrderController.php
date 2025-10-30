<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function index(){
        return view('frontend.order');
    }
    function detail($slug) {
        return view('frontend.order-detail');
    }
}
