<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiagnosisRequest extends FormRequest
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
            'symptomcode' => 'required',
            'details' => 'required'
        ];
    }

    public function messages()
    {
      return [
        'hn.required' => 'โปรดระบุค่า HN',
        'firstname.required' => 'โปรดระบุชื่อของผู้ป่วย',
        'lastname.required' => 'โปรดระบุนามสกุลของผู้ป่วย',
        'symptomcode.required' => 'โปรดระบุรหัสโรค',
        'details.required' => 'โปรดระบุรายละเอียดการวินิจฉัย'
      ];
    }
}
