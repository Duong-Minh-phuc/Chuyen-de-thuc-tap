<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')
            ->select("id", "topic_id", "title","created_at", "slug", "thumbnail", "status", "type")
            ->with(['topic'])
            ->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $posts
        ]);
    }
    public function detail(string $slug)
    {
        $post = Post::where('slug', $slug)->first();
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $post
        ]);
    }
    public function topic(string $slug)
    {
        $posts = Post ::join('topic', 'post.topic_id', '=', 'topic.id')
       -> where('topic.slug', $slug)
        ->select('post.id', 'post.title', 'post.slug', 'post.created_at', 'post.thumbnail', 'post.status', 'post.type', 'topic.name as topic_name', 'topic.slug as topic_slug')
        ->paginate(12);
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $posts 
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts = Post::orderBy('created_at', 'ASC')
            ->select('id', 'title')
            ->get();
        
        $topics = Topic::orderBy('name', 'ASC')
            ->select('id', 'name')
            ->get();

        $types = Post::select('type')
            ->distinct()
            ->pluck('type');

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => [
                'posts' => $posts,
                'topics' => $topics,
                'types' => $types
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        if (!$request->hasFile('thumbnail')) {
            return response()->json([
                'status' => false,
                'message' => 'Chưa chọn hình',
                'data' => null
            ]);
        }

        $post = new Post();
        $file = $request->file('thumbnail');
        $extension = $file->extension();
        $filename = date('YmdHis') . "." . $extension;
        $file->move(public_path('images/post'), $filename);
        
        $post->thumbnail = $filename;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->type = $request->type;
        $post->topic_id = $request->topic_id;
        $post->content = $request->content;
        $post->description = $request->description;
        $post->created_by = Auth::id() ?? 1;
        $post->created_at = date('Y-m-d H:i:s');
        $post->status = $request->status;
        
        if($post->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thêm thành công',
                'data' => $post
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể thêm',
            'data' => null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $posts = Post::orderBy('created_at', 'ASC')
            ->select('id', 'title')
            ->get();
        
        $topics = Topic::orderBy('name', 'ASC')
            ->select('id', 'name')
            ->get();
        
        $types = Post::select('type')
            ->distinct()
            ->pluck('type');
        
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => [
                'post' => $post,
                'posts' => $posts,
                'topics' => $topics,
                'types' => $types
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->type = $request->type;
        $post->topic_id = $request->topic_id;
        $post->content = $request->content;
        $post->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail && File::exists(public_path("images/post/" . $post->thumbnail))) {
                File::delete(public_path("images/post/" . $post->thumbnail));
            }
            $file = $request->file('thumbnail');
            $extension = $file->extension();
            $filename = date('YmdHis') . "." . $extension;
            $file->move(public_path('images/post'), $filename);
            $post->thumbnail = $filename;
        }

        $post->updated_by = Auth::id() ?? 1;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->status = $request->status;

        if ($post->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $post
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể cập nhật',
            'data' => null
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $post = Post::withTrashed()->find($id);
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($post->thumbnail && File::exists(public_path("images/post/" . $post->thumbnail))) {
            File::delete(public_path("images/post/" . $post->thumbnail));
        }
        
        $post->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công',
            'data' => null
        ]);
    }

    public function trash()
    {
        $posts = Post::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $posts
        ]);
    }

    public function status(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $post->status = ($post->status == 1) ? 2 : 1;
        $post->updated_by = Auth::id() ?? 1;
        $post->updated_at = date('Y-m-d H:i:s');
        
        if ($post->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thay đổi trạng thái thành công',
                'data' => $post
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
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($post->delete()) {
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
        $post = Post::withTrashed()->find($id);
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($post->restore()) {
            return response()->json([
                'status' => true,
                'message' => 'Khôi phục thành công',
                'data' => $post
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể khôi phục',
            'data' => null
        ]);
    }
}
