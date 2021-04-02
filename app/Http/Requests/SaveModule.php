<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveModule extends FormRequest
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
        $params = $this->route()->parameters();
        return [
            'slug'  => 'bail|required|unique:tbl_modules,slug' . (array_key_exists('module', $params) ? ", {$params['module']}" : ''),
        ];
    }

    public function all() {
        $attributes = parent::all();

        return $attributes;
    }
}
