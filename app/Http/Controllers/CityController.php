<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function delhi()
    {
        return view('delhi');
    }

    public function goaTour()
    {
        return view('goaTour');
    }

    public function manali()
    {
        return view('manali');
    }

    public function kerala(Request $request)
    {
        return view('kerala');
    }

    public function coimbatore()
    {
        return view('coimbatore');
    }

    public function mussoorie()
    {
        return view('mussoorie');
    }
}
