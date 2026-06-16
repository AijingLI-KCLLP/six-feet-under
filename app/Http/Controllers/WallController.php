<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WallController extends Controller
{
    public function index()
    {
        $thoughts = [
            "OIIAI",
            "never six without seven",
            "Je vole croquette de mon chien",
        ];

        return view('wall', compact('thoughts'));
    }
}
