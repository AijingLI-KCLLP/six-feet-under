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

        $posts = Post::latest()->get();

        return view('wall', compact('posts'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'body' => 'required|string|max:255',
        ]);

        Post::create($validated);
        return redirect('/');
    }



    public function kudo(Post $post){
        $kudoed = session()->get('kudoed',[]);
        if (in_array($post->id, $kudoed)){ return redirect('/'); }

        session()->push('kudoed', $post->id);

        $post->increment('kudos');

        if ($post->kudos >= config('wall.kudos_to_vanish', 6)) {
            $post->delete();
        }

        return redirect('/');
    }
}
