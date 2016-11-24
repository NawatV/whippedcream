<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeeEditedMyPatientInformationRequest extends FormRequest
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
            'birthDate' => 'required|date_format: Y-m-d',
            'phoneNumber' => 'required|digits_between:9,10',
            'email' => 'required|email',
            'address' => 'required',
            'gender' => 'required',
            'bloodType' => 'required',
            'allergen' => 'required'
        ];
    }

    public function messages()
    {
        return [
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
