<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveHoidong extends FormRequest
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
            'slug' => 'bail|required|unique:tbl_contents,slug' . (array_key_exists('post', $params) ? ", {$params['post']}" : ''),
        ];
    }

    public function all() {

        $attributes = parent::all();
        $attributes['desc_vn'] = 'hoidong';
        $attributes['resource_id'] = $attributes['resource_id'] !== '' ? (int) $attributes['resource_id'] : NULL;
        return $attributes;

    }
}
