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
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'idNumber' => 'required|numeric|digit:13',
            'birthDate' => "required|date_format:'d/m/Y'",
            'phoneNumber' => 'required|numeric|digits_between:9,10',
            'email' => 'required|email',
            'address' => 'required',
//            'gender' => 'required',
//            'bloodType' => 'required',
            'username' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'โปรดระบุชื่อของบัญชีผู้ใช้',
            'password.required' => 'โปรดระบุรหัสผ่านของบัญชีผู้ใช้',
            'idNumber' => 'โปรดระบุเลขประจำตัวประชาชนของผู้ใช้',
            'firstname.required' => 'โปรดระบุชื่อของผู้ใช้',
            'lastname.required' => 'โปรดระบุนามสกุลของผู้ใช้',
//            'gender.required' => 'โปรดระบุเพศของผู้ใช้',
            'birthDate.required' => 'โปรดระบุวันเกิดของผู้ใช้',
            'phoneNumber.required' => 'โปรดระบุหมายเลขโทรศัพท์ของผู้ใช้',
            'email.required' => 'โปรดระบุอีเมลของผู้ใช้',
            'address.required' => 'โปรดระบุที่อยู่ของผู้ใช้'
        ];
    }
}
