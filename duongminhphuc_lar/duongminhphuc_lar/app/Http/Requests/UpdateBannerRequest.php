<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'position' => 'required',
            'sort_order' => 'required',
            'status' => 'required|in:1,2'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên banner',
            'name.max' => 'Tên banner không được vượt quá 255 ký tự',
            'link.required' => 'Vui lòng nhập liên kết',
            'image.image' => 'File phải là hình ảnh',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'image.max' => 'Kích thước hình ảnh tối đa là 2MB',
            'position.required' => 'Vui lòng nhập vị trí',
            'sort_order.required' => 'Vui lòng chọn vị trí sắp xếp',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
} 