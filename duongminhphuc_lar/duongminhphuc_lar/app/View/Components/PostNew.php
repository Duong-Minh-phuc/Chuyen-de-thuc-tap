<?php

namespace App\View\Components;
use App\Models\Post;
use Illuminate\View\Component;

class PostNew extends Component
{
    public function render()
    {
        $posts = Post::where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(4);
                    
        return view('components.post-new', compact('posts'));
    }
} 