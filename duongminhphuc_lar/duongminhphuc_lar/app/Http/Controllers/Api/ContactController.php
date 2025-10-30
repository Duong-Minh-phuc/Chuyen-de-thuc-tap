<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')
            ->select("id", "name", "email", "phone", "title", "content", "status", "created_at")   
            ->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $contacts
        ]);
    }

    public function create() {
        return view('backend.contact.create');
    }

    public function store(Request $request)
    {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->title = $request->title;
        $contact->content = $request->content;
        $contact->created_by = Auth::id() ?? 1;
        $contact->status = $request->status;

        if ($contact->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thêm thành công',
                'data' => $contact
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
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $contact
        ]);
    }

    public function edit(string $id)
    {
        $contact = Contact::where('id', $id)->first();
        return view('backend.contact.edit', compact('contact'));
    }

    public function update(Request $request, string $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->title = $request->title;
        $contact->content = $request->content;
        $contact->updated_by = Auth::id() ?? 1;
        $contact->updated_at = date('Y-m-d H:i:s');
        $contact->status = $request->status;

        if ($contact->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $contact
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
        $contact = Contact::withTrashed()->find($id);
        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $contact->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa thành công',
            'data' => null
        ]);
    }

    public function trash()
    {
        $contacts = Contact::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $contacts
        ]);
    }

    public function status(string $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        $contact->status = ($contact->status == 1) ? 2 : 1;
        $contact->updated_by = Auth::id() ?? 1;
        $contact->updated_at = date('Y-m-d H:i:s');
        
        if ($contact->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Thay đổi trạng thái thành công',
                'data' => $contact
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
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($contact->delete()) {
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
        $contact = Contact::withTrashed()->find($id);
        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        if ($contact->restore()) {
            return response()->json([
                'status' => true,
                'message' => 'Khôi phục thành công',
                'data' => $contact
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể khôi phục',
            'data' => null
        ]);
    }

    public function reply(Request $request, string $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([
                'status' => false,
                'message' => 'Không tồn tại mẫu tin',
                'data' => null
            ]);
        }

        // Add your reply logic here
        $contact->reply = $request->reply;
        $contact->replied_at = date('Y-m-d H:i:s');
        $contact->replied_by = Auth::id() ?? 1;

        if ($contact->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Trả lời thành công',
                'data' => $contact
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không thể trả lời',
            'data' => null
        ]);
    }
}
