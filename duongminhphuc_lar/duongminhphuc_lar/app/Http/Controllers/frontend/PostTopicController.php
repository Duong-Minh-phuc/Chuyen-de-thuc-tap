<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Post;

class PostTopicController extends Controller
{
    public function index($slug)
    {
        $topic = Topic::where('slug', $slug)->firstOrFail();
        $posts = Post::where('topic_id', $topic->id)
        ->where('status', 1)
        ->paginate(4)
        ->withQueryString();
     

        return view('frontend.post-topic', [
            'topic' => $topic,
            'posts' => $posts,
        ]);
    }
}