<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
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
            'patientId' => 'required|digits:13',
            'doctorId' => 'required',
            'appDate' => 'required',
            'appTime' => 'required',
            'symptom' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'patientId.required' => 'โปรดระบุเลขรหัสประจำตัวประชาชน',
            'patientId.digits' => 'รหัสเลขประจำตัวประชาชนผิด กรุณาตรวจสอบอีกครั้ง',
            'doctorId.required' => 'โปรดเลือกหมดที่ต้องการพบ',
            'appDate.required' => 'โปรดเลือกวันที่ต้องการจะนัดหมาย',
            'appTime.required' => 'โปรดเลือกเวลา',
            'symptom.required' => 'โปรดระบุอาการ'
        ];
    }
}
