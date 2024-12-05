<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusController extends Controller
{
    public function  index()
    {
        return view('bus');
    }
}
