<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'sort_order' => 'required',
            'status' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên thương hiệu bắt buộc nhập',
            'slug.required' => 'Slug bắt buộc nhập',
            'image.required' => 'Vui lòng chọn một hình ảnh',
            'image.image' => 'Tệp tải lên phải là một hình ảnh',
            'image.mimes' => 'Hình ảnh phải thuộc các định dạng: jpeg, png, jpg, gif, webp',
            'sort_order.required' => 'Thứ tự bắt buộc chọn',
            'status.required' => 'Trạng thái bắt buộc chọn'
        ];
    }
}
