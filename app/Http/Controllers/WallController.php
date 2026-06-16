<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class WallController extends Controller
{
    public function index(){
/*        $thoughts = [
            "OIIAI",
            "never six without seven",
            "Je vole croquette de mon chien",
        ];*/

        $posts = Post::latest()->get(['body', 'kudos']);

        return view('wall', compact('posts'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'body' => 'required|string|max:255',
        ]);

        Post::create($validated);
        return redirect('/');
    }
}
