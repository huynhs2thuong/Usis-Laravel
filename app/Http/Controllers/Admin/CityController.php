<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\City;

use Validator;
use Cache;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cities = /*Cache::remember('cities', 43200, function() {
                return */City::get();
            //});
            $rows = [];
            foreach ($cities as $city) {
                $rows[] = [
                    NULL,
                    $city->title,
                    $city->code,
                    $city->is_delivery_html,
                    '<a class="waves-effect waves-light btn btn-sm" href="' . action('Admin\CityController@edit', $city->id) . '">' . trans('admin.button.edit') . '</a>'
                ];
            }
            return response()->json(['data' => $rows]);
        }
        return view('admin.city.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|array',
            'code' => 'required|unique:cities,code',
            'delivery' => 'boolean'
        ]);
        if ($validator->fails()) return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);

        if (!$request->exists('delivery')) $request->merge(['delivery' => false]);

        City::create($request->all());
        return response()->json(['status' => 'success', 'message' => trans('admin.message.create')]);
    }

    public function edit($id) {
        $city = City::findOrFail($id);
        return view('admin.city.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->update([
            'title' => $request->title,
            'delivery' => $request->get('delivery', false)
        ]);
        return response()->json(['status' => 'success', 'message' => trans('admin.message.update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        City::destroy($id);
        return redirect()->action('Admin\CityController@index');
    }
}
