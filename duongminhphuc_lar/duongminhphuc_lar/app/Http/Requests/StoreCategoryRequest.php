<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'parent_id' => 'required',
            'sort_order' => 'required',
            'status' => 'required'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục bắt buộc nhập',
            'slug.required' => 'Slug bắt buộc nhập',
            'image.required' => 'Vui lòng chọn một hình ảnh',
            'image.image' => 'Tệp tải lên phải là một hình ảnh',
            'image.mimes' => 'Hình ảnh phải thuộc các định dạng: jpeg, png, jpg, gif, webp',
            'parent_id.required' => 'Danh mục cha bắt buộc chọn',
            'sort_order.required' => 'Thứ tự bắt buộc chọn',
            'status.required' => 'Trạng thái bắt buộc chọn'
        ];
    }
}
