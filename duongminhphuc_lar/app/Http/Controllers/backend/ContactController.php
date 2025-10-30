<?php

namespace App\Http\Controllers\backend;
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
            ->select("id","name", "email", "phone", "title", "content", "status","created_at")   
            ->paginate(5);
        return view('backend.contact.index', compact('contacts'));
    }

    public function create() {
        return view('backend.contact.create');
    }

    public function store(Request $request) {
        // xử lý thêm
    }

    public function show(string $id)
    {
        $contacts = Contact::where('id', $id)->first();
        if ($contacts == null) {
            return redirect()->back()->with('error', 'Không tồn tại mẫu tin');
        }
        return view('backend.contact.show', compact('contacts'));
    }

    public function edit(string $id)
    {
        $contact = Contact::where('id', $id)->first();
        return view('backend.contact.edit', compact('contact'));
    }

    public function update(Request $request, string $id)
    {
        $contact = Contact::where('id', $id)->first();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->title = $request->title;
        $contact->content = $request->content;
        $contact->updated_by = Auth::id() ?? 1;
        $contact->updated_at = date('Y-m-d H:i:s');
        $contact->status = $request->status;
        if ($contact->save()) {
            return redirect()->route('admin.contact.index')->with('success', 'Contact update successfully');
        }
        return redirect()->back()->with('error', 'Failed to update contact');
    }

    public function destroy(string $id)
    {
        $contacts = Contact::withTrashed()->where('id', $id)->first();
        if ($contacts != null) {
            //Xóa hình
            if ($contacts->image && File::exists(public_path("images/contact/" . $contacts->image))) {
                File::delete(public_path("images/contact/" . $contacts->image));
            }
            $contacts->forceDelete();
            return redirect()->route('admin.contact.trash')->with('success', 'Xóa thành công');
        }
        return redirect()->route('admin.contact.trash')->with('error', 'Mẫu tin không tồn tại');
    }
    public function trash() {
        $contacts = Contact::onlyTrashed()
            ->orderBy('created_at', 'DESC')
            ->paginate(8);
        return view('backend.contact.trash', compact('contacts'));
    }

    public function status(string $id)
    {
        $contact     = Contact::find($id);
        if($contact == null) {
            return redirect()->route('admin.contact.index')
                ->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        // Chuyển đổi trạng thái
        $contact->status = ($contact->status == 1) ? 2 : 1;
        $contact->updated_by = Auth::id() ?? 1;
        $contact->updated_at = date('Y-m-d H:i:s');
        $contact->save();

        return redirect()->route('admin.contact.index')
            ->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }

    public function delete(string $id) {
        $contacts = Contact::find($id);
        if($contacts == null) {
            return redirect()->route('admin.contact.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $contacts->delete();
        return redirect()->route('admin.contact.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công!']);
    }

    public function restore(string $id)
    {
        $contacts = Contact::withTrashed()->where('id', $id);
        if ($contacts->first() != null) {
            $contacts->restore();
            return redirect()->route('admin.contact.trash')->with('success', 'Khôi phục thành công');
        }
        return redirect()->route('admin.contact.trash')->with('error', 'Mẫu tin không tồn tại');
    }
}
