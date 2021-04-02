<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePage extends FormRequest
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
            'slug' => 'bail|required|unique:pages,slug' . (array_key_exists('page', $params) ? ", {$params['page']}" : ''),
            'active' => 'boolean'
            //'page_id' => 'nullable|exists:pages,id'
        ];
    }

    public function all() {
        $attributes = parent::all();
        $linksave = [];
        if(isset($attributes['linksgo'])){
            foreach($attributes['linksgo'] as $link){
                $data = explode(',', $link);
                $arr = array();
                if(isset($data[1])){
                    $arr['vn'] = $data[1];
                }
                if(isset($data[2])){
                    $arr['en'] = $data[2];
                }
                $linksave[$data[0]] = $arr;  
                
            }
        }
        $getlinks = serialize($linksave);
        $attributes['links'] = $getlinks;
        $attributes['resource_id'] = $attributes['resource_id'] !== '' ? (int) $attributes['resource_id'] : NULL;
        $attributes['feature'] = $attributes['feature'] !== '' ? (int) $attributes['feature'] : NULL;
        $attributes['page_id'] = isset($attributes['page_id']) ? (int) $attributes['page_id'] : NULL;
        $attributes['gallery'] = array_key_exists('gallery', $attributes) ? (array) $attributes['gallery'] : [];
        $attributes['banner'] = array_key_exists('banner', $attributes) ? (array) $attributes['banner'] : [];
        return $attributes;
    }
}
