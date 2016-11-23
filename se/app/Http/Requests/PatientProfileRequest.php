<?php

namespace App\Http\Requests;
use App\Model\Appointment;
use App\Model\Diagnosis;
use App\Model\Doctor;
use App\Model\Patient;
use App\Model\Prescription;
use App\Model\User;

use Illuminate\Foundation\Http\FormRequest;

class PatientProfileRequest extends FormRequest
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
            //
            'hn' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'idNumber' => 'required|digits:13',
            'birthDate' => 'required|date_format: d/m/Y',
            'address' => 'required',
            'phoneNumber' => 'required|digits_between:9,10',
            'email' => 'required|email',
            'bloodType' => 'required',
            'allergen' => 'required'
        ];
    }


    public function messages()
    {
      return [
        'hn.required' => 'โปรดระบุรหัสประจำตัวของผู้ป่วย',
        'firstname.required' => 'โปรดระบุชื่อของผู้ป่วย',
        'lastname.required' => 'โปรดระบุนามสกุลของผู้ป่วย',
        'gender.required' => 'โปรดระบุเพศของผู้ป่วย',
        'idNumber.required' => 'โปรดระบุรหัสประจำตัวประชาชนของผู้ป่วย',
        'idNumber.digits' => 'รูปแบบรหัสประจำตัวประชาชนไม่ถูกต้อง',
        'birthDate.required' => 'โปรดระบุวันเกิดของผู้ป่วย',
        'birthDate.date_format' => 'รูปแบบวันเกิดไม่ถูก',
        'address.required' => 'โปรดระบุที่อยู่ของผู้ป่วย',
        'phoneNumber.required' => 'โปรดระบุเบอร์โทรศัพท์',
        'phoneNumber.digits_between' => 'รูปแบบของเบอร์โทรศัพท์ไม่ถูกต้อง',
        'email.required' => 'โปรดระบบอีเมลของผู้ป่วย',
        'email.email' => 'รูปแบบของอีเมลไม่ถูกต้อง',
        'bloodType.required' => 'โปรดระบุกรุ๊ปเลือด',
        'allergen.required' => 'โปรดระบุประวัติการแพ้ยา'

      ];
    }
}
