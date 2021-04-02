<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProject extends FormRequest
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
            'slug' => 'bail|required|unique:projects,slug' . (array_key_exists('project', $params) ? ", {$params['project']}" : ''),
            'active' => 'required|boolean',
            'sticky' => 'required|boolean',
        ];
    }

    public function all() {

        $attributes = parent::all();
        $attributes['overview_id'] = $attributes['overview_id'] !== '' ? (int) $attributes['overview_id'] : NULL;
        $attributes['resource_id'] = $attributes['resource_id'] !== '' ? (int) $attributes['resource_id'] : NULL;
        $attributes['sticky'] = isset($attributes['sticky']) ? (boolean) $attributes['sticky'] : false;
        $attributes['img_slide'] = array_key_exists('img_slide', $attributes) ? (array) $attributes['img_slide'] : [];
        return $attributes;

    }
}
