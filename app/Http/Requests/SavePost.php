<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePost extends FormRequest
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
            'active' => 'required|boolean',
            'sticky' => 'required|boolean'
        ];
    }

    public function all() {

        $attributes = parent::all();
        $attributes['resource_id'] = $attributes['resource_id'] !== '' ? (int) $attributes['resource_id'] : NULL;
        $attributes['sticky'] = isset($attributes['sticky']) ? (boolean) $attributes['sticky'] : false;
        $attributes['service_display'] = isset($attributes['service_display']) ? $attributes['service_display'] : 0;
        $attributes['gallery'] = array_key_exists('gallery', $attributes) ? (array) $attributes['gallery'] : [];
        return $attributes;

    }
}
