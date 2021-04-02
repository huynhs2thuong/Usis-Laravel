<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\City;
use App\District;

use Validator;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($city_id)
    {
        $districts = District::where('city_id', $city_id)->orderBy('title', 'asc')->get();
        $rows = [];
        foreach ($districts as $district) {
            $rows[] = [
                NULL,
                view('partials.lang_input', ['type' => 'text', 'model' => 'district', 'district' => $district, 'attr' => 'title'])->render(),
                $district->code,
                '<input type="number" min="50000" max="150000" step="1000" class="form-control" name="min_price" value="' . $district->min_price . '">',
                \Form::checkbox('delivery', 1, $district->delivery, ['class' => 'filled-in', 'id' => 'delivery-' . $district->id])->toHtml() . '<label for="delivery-' . $district->id . '"></label>',
                '<a href="' . action('Admin\DistrictController@update', [$city_id, $district->id]) . '" class="btn btn-sm waves-light waves-effect green accent-4 district-update">' .trans('admin.button.update') . '</a>' .
                '<a class="btn-delete btn btn-sm waves-light waves-effect red darken-4 district-delete">' . trans('admin.button.delete') . '</a>'
            ];
        }
        return response()->json(['data' => $rows]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $city_id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array',
            'code' => 'required|unique:districts,code',
            'delivery' => 'boolean'
        ]);
        if ($validator->fails()) return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);

        if (!$request->exists('delivery')) $request->merge(['delivery' => false]);

        $request->merge(['city_id' => $city_id]);
        District::create($request->all());
        return response()->json(['status' => 'success', 'message' => trans('admin.message.create')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $city_id, $id)
    {
        $district = District::findOrFail($id);
        $district->update([
            'title' => $request->title,
            'min_price' => $request->min_price,
            'delivery' => $request->delivery
        ]);
        return response()->json(['status' => 'success', 'message' => trans('admin.message.update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($city_id, $id)
    {
        District::destroy($id);
        return response()->json(['status' => 'success', 'message' => trans('admin.message.delete')]);
    }
}
