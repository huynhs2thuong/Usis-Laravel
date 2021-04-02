<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveGroup extends FormRequest
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
            'slug' => 'bail|required|min:3|regex:/^[\w\-]+[a-zA-Z\d]$/|unique:groups,slug' . (array_key_exists('group', $params) ? ", {$params['group']}" : ''),
            'is_side' => 'required|boolean',
            'col' => 'nullable|required_if:is_side,true|in:1,2,3,4',
        ];
    }

    public function all() {
        $attributes = parent::all();

        $attributes['resource_id'] = $attributes['resource_id'] !== '' ? (int) $attributes['resource_id'] : NULL;
        if (array_key_exists('dishes_order', $attributes)) $attributes['dishes_order'] = json_decode($attributes['dishes_order']);
        if ((int) $attributes['is_side'] === 0) $attributes['col'] = NULL;

        return $attributes;
    }
}
