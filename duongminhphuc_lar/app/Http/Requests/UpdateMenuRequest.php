<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'link' => 'required',
            'type' => 'required',
            'table_id' => 'required',
            'sort_order' => 'required',
            'position' => 'required',
            'status' => 'required|in:1,2'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên menu',
            'name.max' => 'Tên menu không được vượt quá 255 ký tự',
            'link.required' => 'Vui lòng nhập liên kết',
            'type.required' => 'Vui lòng chọn loại menu',
            'table_id.required' => 'Vui lòng chọn bảng liên kết',
            'sort_order.required' => 'Vui lòng chọn vị trí sắp xếp',
            'position.required' => 'Vui lòng nhập vị trí',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
} 