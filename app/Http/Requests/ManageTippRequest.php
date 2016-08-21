<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ManageTippRequest extends Request
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
            'kt_points' => 'numeric|min:0',
            'tt_points' => 'numeric|min:0',
            'st_points' => 'numeric|min:0',
            'm_points' => 'numeric'
        ];
    }

    public function messages()
    {
        return [
            'min' => ':attribute muss größer :min sein.',
            'numeric' => ':attribute muss eine Zahl sein',
        ];
    }

    public function attributes()
    {
        return [
          'kt_points' => 'Kopftreffer (Punkte)',
          'tt_points' => 'Tendenztreffer (Punkte)',
          'st_points' => 'Treffer (Punkte)',
          'm_points' => 'Kopftreffer (Punkte)',
        ];
    }
}
