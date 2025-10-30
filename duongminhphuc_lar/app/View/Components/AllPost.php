<?php

namespace App\View\Components;
use App\Models\Post;
use Illuminate\View\Component;

class AllPost extends Component
{
    public function render()
    {
        $posts = Post::where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6);
                    
        return view('components.all-post', compact('posts'));
    }
} 