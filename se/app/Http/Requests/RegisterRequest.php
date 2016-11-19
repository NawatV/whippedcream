<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userId' => 'numeric',
            'username' => 'required',
            'password' => 'required',
            'idNumber' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'birthDate' => 'required|date',
            'phoneNumber' => 'required',
            'email' => 'required',
            'address' => 'required'
            'userType' => 'required'
        ];
    }

    public function messages()
    {
        return [
           //'userId' => 'โปรดระบุเลขประจำตัวของบัญชีผู้ใช้',
          'username.required' => 'โปรดระบุชื่อของบัญชีผู้ใช้',
          'password.required' => 'โปรดระบุรหัสผ่านของบัญชีผู้ใช้',
          'idNumber' => 'โปรดระบุเลขประจำตัวประชาชนของผู้ใช้',
          'firstname.required' => 'โปรดระบุชื่อของผู้ใช้',
            'lastname.required' => 'โปรดระบุนามสกุลของผู้ใช้',
            'gender.required' => 'โปรดระบุเพศของผู้ใช้',
            'birthDate.required' => 'โปรดระบุวันเกิดของผู้ใช้',
            'phoneNumber.required' => 'โปรดระบุหมายเลขโทรศัพท์ของผู้ใช้',
            'email.required' => 'โปรดระบุอีเมลของผู้ใช้',
            'address.required' => 'โปรดระบุที่อยู่ของผู้ใช้'
            //'userType.required' => 'โปรดระบุประเภทของผู้ใช้'
        ];
    }
}
