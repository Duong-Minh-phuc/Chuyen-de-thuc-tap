<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'slug' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'topic_id' => 'required',
            'type' => 'required',
            'description' => 'required',
            'status' => 'required|in:1,2'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'slug.required' => 'Vui lòng nhập slug',
            'content.required' => 'Vui lòng nhập nội dung',
            'thumbnail.image' => 'File phải là hình ảnh',
            'thumbnail.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'thumbnail.max' => 'Kích thước hình ảnh tối đa là 2MB',
            'topic_id.required' => 'Vui lòng chọn chủ đề',
            'type.required' => 'Vui lòng chọn loại bài viết',
            'description.required' => 'Vui lòng nhập mô tả',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
} 