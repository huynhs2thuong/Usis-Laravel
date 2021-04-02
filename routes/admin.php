<?php
Route::group(['prefix' => '@dmin', 'middleware' => ['auth'], 'namespace' => 'Admin'], function() {

    Route::post('logout', 'LoginController@logout')->name('logout_admin');

	Route::get('/', function() {
		return view('admin.dashboard');
	});

	Route::post('post/preview', 'PostController@preview');

    Route::post('service/preview', 'ServiceController@preview');


    Route::resource('post', 'PostController');

    Route::resource('hoidong', 'HoidongController');

	Route::resource('service', 'ServiceController');

	Route::resource('othermember','OmemberController');

    Route::resource('page', 'PageController');
    Route::get('get-category', 'PostController@getCategory');

	Route::resource('store', 'StoreController');
	Route::get('/store/delete/{id}', 'StoreController@delete');

	Route::resource('category', 'CategoryController');
	Route::resource('module', 'ModuleController');
	Route::resource('project', 'ProjectController');
	Route::resource('group', 'GroupController');

	Route::resource('menu', 'MenuController');

	Route::resource('form', 'FormController');

	Route::resource('mail', 'MailController');

	Route::resource('city', 'CityController', ['except' => ['create', 'show']]);
	Route::resource('city.district', 'DistrictController', ['except' => ['create', 'show', 'edit']]);

	Route::resource('user', 'UserController');

	Route::group(['prefix' => 'contact'], function() {
		Route::get('/', 'ContactController@index');
		Route::post('export', 'ContactController@export');
		Route::delete('{id}', 'ContactController@destroy');
	});

	Route::resource('resource', 'ResourceController', ['only' => ['store', 'video', 'destroy']]);
	Route::post('basic','SettingController@basicSetting');
	Route::get('basic','SettingController@basicSetting');
	// Route::put('updateBasic','SettingController@updateBasic');
	Route::post('updateBasic','SettingController@updateBasic');
	Route::post('removeResource','SettingController@removeResource');

	//sort post
	Route::post('sortpost','PostController@sortPost');
	Route::get('sortpost','PostController@sortPost');

	//sort projects
	Route::post('sortproject','ProjectController@sortProject');
	Route::get('sortproject','ProjectController@sortProject');

	Route::get('file-manager','SettingController@filemanager');

	Route::get('redirect','SettingController@redirectLink');
	Route::post('updateRedirect','SettingController@updateRedirect');
});
