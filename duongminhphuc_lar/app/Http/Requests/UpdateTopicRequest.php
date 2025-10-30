<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'slug' => 'required',
            'sort_order' => 'required',
            'status' => 'required|in:1,2'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên chủ đề',
            'name.max' => 'Tên chủ đề không được vượt quá 255 ký tự',
            'slug.required' => 'Vui lòng nhập slug',
            'sort_order.required' => 'Vui lòng chọn vị trí sắp xếp',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
} 