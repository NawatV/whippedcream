<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VitalSignRequest extends FormRequest
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
            'hn' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'temperature' => 'required|numeric',
            'pulse' => 'required|numeric',
            'systolic' => 'required|numeric',
            'diastolic' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
          'hn.required' => 'โปรดระบุค่า HN',
          'firstname.required' => 'โปรดระบุชื่อของผู้ป่วย',
          'lastname.required' => 'โปรดระบุค่านามสกุลของผู้ป่วย',
          'weight.required' => 'โปรดระบุค่าน้ำหนัก',
          'weight.numeric' => 'โปรดระบุค่าน้ำหนักเป็นตัวเลข',
          'height.required' => 'โปรดระบุค่าส่วนสูง',
          'height.numeric' => 'โปรดระบุค่าส่วนสูงเป็นตัวเลข',
          'temperature.required' => 'โปรดระบุค่าอุณหภูมิ',
          'temperature.numeric' => 'โปรดระบุค่าอุณหภูมิเป็นตัวเลข',
          'pulse.required' => 'โปรดระบุค่าชีพจร',
          'pulse.numeric' => 'โปรดระบุค่าชีพจรเป็นตัวเลข',
          'systolic.required' => 'โปรดระบุค่าความดันโลหิต Systolic',
          'systolic.numeric' => 'โปรดระบุุค่าความดันโลหิต Systolic เป็นตัวเลข',
          'diastolic.required' => 'โปรดระบุุค่าความดันโลหิต Diastolic',
          'diastolic.numeric' => 'โปรดระบุุค่าความดันโลหิต Diastolic เป็นตัวเลข',
        ];
    }
}
