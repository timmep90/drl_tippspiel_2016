<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Match;

class TippRequest extends Request
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
            'club1_tipp.*' => 'between:0,19|numeric',
            'club2_tipp.*' => 'between:0,19|numeric'
        ];
    }

    public function messages()
    {
        return[
            'between' => ':attribute sind unzulässig. Es können nur positive Zahlen kleiner :max getippt werden',
            'numeric' => 'Die :attribute müssen aus Zahlen bestehen.'
        ];
    }

    public function attributes()
    {
        return [
            'club1_tipp.*' => 'Tipps',
            'club2_tipp.*' => 'Tipps',
        ];
    }
}
