<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Post;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::where('status', 1)
            ->select('id', 'name', 'slug', 'description', 'status')
            ->orderBy('created_at', 'DESC')
            ->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $topics
        ]);
    }

    public function create()
    {
        $topics = Topic::orderBy('sort_order', 'ASC')
            ->select('id', 'name', 'sort_order')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $topics
        ]);
    }

    public function store(StoreTopicRequest $request)
    {
        $topic = new Topic();
        $topic->name = $request->name;
        $topic->description = $request->description;
        $topic->sort_order = $request->sort_order;
        $topic->slug = $request->slug;
        $topic->created_by = Auth::id() ?? 1;
        $topic->created_at = date('Y-m-d H:i:s');
        $topic->status = $request->status;
        
        if($topic->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thêm thành công',
                'data' => $topic
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể thêm',
            'data' => null
        ]);
    }

    public function show(string $id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $topic
        ]);
    }

    public function edit(string $id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $topics = Topic::orderBy('sort_order', 'ASC')
            ->select("id", "name", "sort_order", "status")
            ->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => [
                'topic' => $topic,
                'topics' => $topics
            ]
        ]);
    }

    public function update(UpdateTopicRequest $request, string $id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $topic->name = $request->name;
        $topic->slug = $request->slug;
        $topic->description = $request->description;
        $topic->sort_order = $request->sort_order;
        $topic->updated_by = Auth::id() ?? 1;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->status = $request->status;

        if ($topic->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $topic
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể cập nhật',
            'data' => null
        ]);
    }

    public function destroy(string $id)
    {
        $topic = Topic::withTrashed()->find($id);
        if (!$topic) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }
        
        $topic->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công',
            'data' => null
        ]);
    }

    public function trash()
    {
        $topics = Topic::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $topics
        ]);
    }

    public function status(string $id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $topic->status = ($topic->status == 1) ? 2 : 1;
        $topic->updated_by = Auth::id() ?? 1;
        $topic->updated_at = date('Y-m-d H:i:s');
        
        if ($topic->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thay đổi trạng thái thành công',
                'data' => $topic
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể thay đổi trạng thái',
            'data' => null
        ]);
    }

    public function delete(string $id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($topic->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa tạm thời thành công',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể xóa',
            'data' => null
        ]);
    }

    public function restore(string $id)
    {
        $topic = Topic::withTrashed()->find($id);
        if (!$topic) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($topic->restore()) {
            return response()->json([
                'status' => true,
                'message' => 'Khôi phục thành công',
                'data' => $topic
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể khôi phục',
            'data' => null
        ]);
    }

    public function posts(string $slug)
    {
        $posts = Post::join('topics', 'posts.topic_id', '=', 'topics.id')
            ->where('topics.slug', $slug)
            ->where('posts.status', 1)
            ->where('posts.type', 'post')
            ->select('posts.id', 'posts.title', 'posts.slug', 'posts.thumbnail', 
                    'posts.status', 'posts.type',
                    'topics.name as topic_name', 'topics.slug as topic_slug')
            ->orderBy('posts.created_at', 'DESC')
            ->paginate(12);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $posts
        ]);
    }
}
