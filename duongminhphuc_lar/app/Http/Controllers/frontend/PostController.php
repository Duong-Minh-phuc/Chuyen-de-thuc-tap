<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(8);
                    
        return view('frontend.post', compact('posts'));
    }
    public function new()
    {
        
        return view('frontend.postnew');
    }

    public function detail($slug)
    {
        $post = Post::where('slug', $slug)
                    ->where('status', 1)
                    ->firstOrFail();
        
        $related_posts = Post::where('status', 1)
                            ->where('id', '!=', $post->id)
                            ->limit(3)
                            ->get();
                    
        return view('frontend.post-detail', compact('post', 'related_posts'));
    }
}
