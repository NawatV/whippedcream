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
            'weight' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'temperature' => 'required|numeric|min:1',
            'pulse' => 'required|numeric|min:1',
            'systolic' => 'required|numeric|min:1',
            'diastolic' => 'required|numeric|min:1'
        ];
    }

    public function messages()
    {
        return [
          'hn.required' => 'โปรดระบุค่า HN',
          'firstname.required' => 'โปรดระบุชื่อของผู้ป่วย',
          'lastname.required' => 'โปรดระบุนามสกุลของผู้ป่วย',
          'weight.required' => 'โปรดระบุค่าน้ำหนัก',
          'weight.numeric' => 'โปรดระบุค่าน้ำหนักเป็นตัวเลข',
          'weight.min' => 'ระบุค่าน้ำหนักเป็นจำนวนลบหรือศูนย์ไม่ได้',
          'height.required' => 'โปรดระบุค่าส่วนสูง',
          'height.numeric' => 'โปรดระบุค่าส่วนสูงเป็นตัวเลข',
          'height.min' => 'ระบุค่าส่วนสูงเป็นจำนวนลบหรือศูนย์ไม่ได้',
          'temperature.required' => 'โปรดระบุค่าอุณหภูมิ',
          'temperature.numeric' => 'โปรดระบุค่าอุณหภูมิเป็นตัวเลข',
          'temperature.min' => 'ระบุค่าอุณหภูมิเป็นจำนวนลบหรือศูนย์ไม่ได้',
          'pulse.required' => 'โปรดระบุค่าชีพจร',
          'pulse.numeric' => 'โปรดระบุค่าชีพจรเป็นตัวเลข',
          'pulse.min' => 'ระบุค่าชีพจรเป็นจำนวนลบหรือศูนย์ไม่ได้',
          'systolic.required' => 'โปรดระบุค่าความดันโลหิต Systolic',
          'systolic.numeric' => 'โปรดระบุค่าความดันโลหิต Systolic เป็นตัวเลข',
          'systolic.min' => 'ระบุค่าความดันโลหิต Systolic เป็นจำนวนลบหรือศูนย์ไม่ได้',
          'diastolic.required' => 'โปรดระบุค่าความดันโลหิต Diastolic',
          'diastolic.numeric' => 'โปรดระบุค่าความดันโลหิต Diastolic เป็นตัวเลข',
          'diastolic.min' => 'ระบุค่าความดันโลหิต Diastolic เป็นจำนวนลบหรือศูนย์ไม่ได้'
        ];
    }
}
