<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCategory extends FormRequest
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
            'slug'  => 'bail|required|unique:tbl_categories,slug' . (array_key_exists('category', $params) ? ", {$params['category']}" : ''),
        ];
    }

    public function all() {
        $attributes = parent::all();

        $attributes['resource_id'] = $attributes['resource_id'] !== '' ? (int) $attributes['resource_id'] : NULL;
        $attributes['cid'] = isset($attributes['cid']) ? (int) $attributes['cid'] : 0;
        //if (array_key_exists('posts_order', $attributes)) $attributes['posts_order'] = json_decode($attributes['posts_order']);

        return $attributes;
    }
}
