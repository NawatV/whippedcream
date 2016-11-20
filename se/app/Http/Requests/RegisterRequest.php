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
            'firstname' => 'required',
            'lastname' => 'required',
            'idNumber' => 'required|digits:13',
            'birthDate' => 'required|date_format: d/m/Y',
            'phoneNumber' => 'required|digits_between:9,10',
            'email' => 'required|email',
            'address' => 'required',
            'gender' => 'required',
            'bloodType' => 'required',
            'username' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'allergen' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'โปรดระบุชื่อของบัญชีผู้ใช้',
            'password.required' => 'โปรดระบุรหัสผ่านของบัญชีผู้ใช้',
            'password.confirmed' => 'ยืนยันรหัสผ่านไม่ถูกต้อง',
            'password_confirmation.required' => 'โปรดระบุยืนยันรหัสผ่านของบัญชีผู้ใช้',
            'idNumber.required' => 'โปรดระบุเลขประจำตัวประชาชนของผู้ใช้',
            'idNumber.digits' => 'โปรดระบุเลขประจำตัวประชาชนของผู้ใช้',
            'firstname.required' => 'โปรดระบุชื่อของผู้ใช้',
            'lastname.required' => 'โปรดระบุนามสกุลของผู้ใช้',
            'gender.required' => 'โปรดระบุเพศของผู้ใช้',
            'bloodType.required' => 'โปรดระบุกรุ๊ปเลือดของผู้ใช้',
            'birthDate.required' => 'โปรดระบุวัน เดือน ปี เกิดของผู้ใช้',
            'birthDate.date_format' => 'โปรดเลือกวัน เดือน ปีเกิดจากปฏิทิน',
            'phoneNumber.required' => 'โปรดระบุหมายเลขโทรศัพท์ของผู้ใช้',
            'phoneNumber.digits_between' => 'โปรดระบุเบอร์โทรศัพท์',
            'email.required' => 'โปรดระบุอีเมลของผู้ใช้',
            'email.email' => 'โปรดระบุอีเมลให้ถูกต้อง',
            'address.required' => 'โปรดระบุที่อยู่ของผู้ใช้',
            'allergen.required' => 'โปรดระบุประวัติการแพ้ยา'
        ];
    }
}
