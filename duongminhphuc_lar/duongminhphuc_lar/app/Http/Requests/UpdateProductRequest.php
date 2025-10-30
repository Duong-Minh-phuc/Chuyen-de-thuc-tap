<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
    
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
   
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'slug' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price_buy' => 'required|numeric|min:0',
            'price_sale' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'status' => 'required|in:1,2'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự',
            'slug.required' => 'Vui lòng nhập slug',
            'content.required' => 'Vui lòng nhập nội dung',
            'thumbnail.image' => 'File phải là hình ảnh',
            'thumbnail.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'thumbnail.max' => 'Kích thước hình ảnh tối đa là 2MB',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'brand_id.required' => 'Vui lòng chọn thương hiệu',
            'price_buy.required' => 'Vui lòng nhập giá mua',
            'price_buy.numeric' => 'Giá mua phải là số',
            'price_buy.min' => 'Giá mua phải lớn hơn hoặc bằng 0',
            'price_sale.required' => 'Vui lòng nhập giá bán',
            'price_sale.numeric' => 'Giá bán phải là số',
            'price_sale.min' => 'Giá bán phải lớn hơn hoặc bằng 0',
            'qty.required' => 'Vui lòng nhập số lượng',
            'qty.integer' => 'Số lượng phải là số nguyên',
            'qty.min' => 'Số lượng phải lớn hơn hoặc bằng 0',
            'status.required' => 'Vui lòng chọn trạng thái',
            'status.in' => 'Trạng thái không hợp lệ'
        ];
    }
}
