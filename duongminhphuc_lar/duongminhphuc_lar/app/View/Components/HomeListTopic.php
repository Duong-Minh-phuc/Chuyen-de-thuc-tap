<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Topic;

class HomeListTopic extends Component
{
    public function render()
    {
        $args = [
            ['status', '=', '1'],    // Lấy các chủ đề có status = 1 (đang hoạt động)
        ];

        $topics = Topic::where($args)
                           ->orderBy('sort_order', 'DESC')  // Sắp xếp theo sort_order giảm dần
                           ->get();

        return view('components.home-list-topic', compact('topics'));
    }
} 