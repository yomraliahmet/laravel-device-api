<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "uid"       => "required",
            "appId"     => "required",
            "language"  => "required",
            "os"        => "required",
        ];
    }
}
