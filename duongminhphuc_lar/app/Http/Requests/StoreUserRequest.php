<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'roles' => 'required',
            'status' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Họ tên bắt buộc nhập',
            'email.required' => 'Email bắt buộc nhập',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Số điện thoại bắt buộc nhập',
            'username.required' => 'Tên tài khoản bắt buộc nhập',
            'username.unique' => 'Tên tài khoản đã tồn tại',
            'password.required' => 'Mật khẩu bắt buộc nhập',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'thumbnail.image' => 'Tệp tải lên phải là một hình ảnh',
            'thumbnail.mimes' => 'Hình ảnh phải thuộc các định dạng: jpeg, png, jpg, gif, webp',
            'roles.required' => 'Vai trò bắt buộc chọn',
            'status.required' => 'Trạng thái bắt buộc chọn'
        ];
    }
}
