<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/area/{is_delivery?}', function($is_delivery = 1) {
	$cities = Cache::remember('cities', 43200, function() {
        return App\City::all();
    });
    $districts = Cache::remember('districts', 43200, function() {
        return App\District::all();
    });
    if ($is_delivery) {
        $cities = $cities->filter(function ($value, $key) {
            return $value->delivery == true;
        });
        $districts = $districts->filter(function ($value, $key) {
            return $value->delivery == true;
        });
    }
    $data['cities'] = $data['districts'] = [];
    foreach ($cities as $city) {
    	$data['cities'][] = [
    		'id' => $city->id,
    		'title' => $city->getOriginal('title')
    	];
    }
    foreach ($districts as $district) {
    	$data['districts'][] = [
    		'id' => $district->id,
    		'city_id' => $district->city_id,
    		'title' => $district->getOriginal('title'),
    		'min_price' => $district->min_price
    	];
    }

    return response()->json($data);
});

Route::post('/area', function(Request $request) {
	$validator = Validator::make($request->all(), [
        'city' => 'required',
        'district' => 'required',
    ])->validate();

    $city = (int) filter_var($request->city, FILTER_SANITIZE_NUMBER_INT);
    $district = (int) filter_var($request->district, FILTER_SANITIZE_NUMBER_INT);

	$cookie_city = Cookie::forever('customerCity', $city);
    $cookie_district = Cookie::forever('customerDistrict', $district);

	return response()->json(['status' => 'success', 'message' => ''])->cookie($cookie_city)->cookie($cookie_district);
});

Route::get('/store/{district_id}', function(Request $request, $district_id) {
    $stores = App\Store::with('resource')->where('district_id', $district_id)->get();
    $data = [];
    foreach ($stores as $store) {
        $data[] = [
            'title' => $store->getOriginal('title'),
            'slug' => $store->slug,
            'address' => $store->getOriginal('address'),
            'hour' => $store->getOriginal('business_hours'),
            'lat' => $store->lat,
            'lng' => $store->lng,
            'image' => $store->image
        ];
    }

    return response()->json($data);
});

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/
