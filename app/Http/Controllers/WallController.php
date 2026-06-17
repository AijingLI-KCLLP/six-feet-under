<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Events\PostKudoed;
use App\Events\PostVanished;
use App\Models\Post;
use Illuminate\Http\Request;

class WallController extends Controller
{
    public function index(){
        $posts = Post::latest()->get();

        return view('wall', compact('posts'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $post = Post::create($validated);
        PostCreated::dispatch($post);

        return redirect('/');
    }

    public function kudo(Post $post){
        $kudoed = session()->get('kudoed',[]);
        if (in_array($post->id, $kudoed)){ return redirect('/'); }

        session()->push('kudoed', $post->id);

        $post->increment('kudos');
        PostKudoed::dispatch($post);

        if ($post->kudos >= config('wall.kudos_to_vanish', 6)) {
            $post->delete();
            PostVanished::dispatch($post);
        }

        return redirect('/');
    }
}
