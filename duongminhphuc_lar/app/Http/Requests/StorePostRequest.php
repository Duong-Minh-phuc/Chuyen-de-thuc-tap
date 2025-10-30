<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'slug' => 'required',
            'type' => 'required',
            'topic_id' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'sort_order' => 'required',
            'status' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề bắt buộc nhập',
            'slug.required' => 'Slug bắt buộc nhập',
            'type.required' => 'Loại bắt buộc chọn',
            'topic_id.required' => 'Chủ đề bắt buộc chọn',
            'thumbnail.required' => 'Vui lòng chọn một hình ảnh',
            'thumbnail.image' => 'Tệp tải lên phải là một hình ảnh',
            'thumbnail.mimes' => 'Hình ảnh phải thuộc các định dạng: jpeg, png, jpg, gif, webp',
            'sort_order.required' => 'Thứ tự bắt buộc chọn',
            'status.required' => 'Trạng thái bắt buộc chọn'
        ];
    }
}
