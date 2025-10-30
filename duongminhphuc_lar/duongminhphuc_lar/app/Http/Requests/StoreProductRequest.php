<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:products',
            'content' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
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
            'slug.max' => 'Slug không được vượt quá 255 ký tự',
            'slug.unique' => 'Slug đã tồn tại trong hệ thống',
            
            'content.required' => 'Vui lòng nhập nội dung sản phẩm',
            
            'thumbnail.required' => 'Vui lòng chọn hình ảnh sản phẩm',
            'thumbnail.image' => 'File phải là hình ảnh',
            'thumbnail.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'thumbnail.max' => 'Kích thước hình ảnh tối đa là 2MB',
            
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục không tồn tại trong hệ thống',
            
            'brand_id.required' => 'Vui lòng chọn thương hiệu',
            'brand_id.exists' => 'Thương hiệu không tồn tại trong hệ thống',
            
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
