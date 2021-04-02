<?php
use App\Setting;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::post('contact', 'Admin\ContactController@store')->middleware('throttle:5');



// Route::get('/huong-dan-dinh-cu-hoa-ky/visa-dinh-cu-my-theo-dien-dau-tu-eb-5',function(){
//      return Redirect::to('/dich-vu/visa-dinh-cu-my-theo-dien-dau-tu-eb-5.html',301);
// });
// Route::get('/huong-dan-dinh-cu-hoa-ky/visa-khong-dinh-cu-my-l-1',function(){
//      return Redirect::to('/dich-vu/visa-khong-dinh-cu-my-l-1.html',301);
// });

//feed rss
Route::get('feed','SiteController@feedCustom')->name('feed');


//redirect tất cả bài tin tuc sang tin
Route::get('/tin-tuc/{slug}','SiteController@redirectPost')->name('redirectPost');
Route::get('en/doi-tac', function(){
    return Redirect::to('en/partners',301);
});
// Route::get('gioi-thieu', function(){
//     return Redirect::to('gioi-thieu/gioi-thieu-usis',301);
// });
Route::get('en/about-us', function(){
    return Redirect::to('en/about-us/about-us',301);
});
// Route::get('gioi-thieu-usis', function(){
//     return Redirect::to('gioi-thieu/gioi-thieu-usis',301);
// });
// Route::get('su-kien', function(){
//     return Redirect::to('su-kien/hoat-dong-usis',301);
// });
Route::get('en/events', function(){
    return Redirect::to('en/events/usis-activities',301);
});
// Route::get('dich-vu/dich-vu-an-cu', function(){
//     return Redirect::to('dich-vu/dich-vu-an-cu-my',301);
// });

Route::get('tin-tuc-usis', function(){
    return Redirect::to('tin-tuc-usis/tin-tuc-my',301);
});
Route::get('en/news', function(){
    return Redirect::to('en/news/us-news',301);
});
// Route::get('visa-dinh-cu-my-theo-dien-dau-tu-eb-5', function(){
//     return Redirect::to('dich-vu/visa-dinh-cu-my-theo-dien-dau-tu-eb-5',301);
// });
// Route::get('visa-khong-dinh-cu-my-l-1', function(){
//     return Redirect::to('dich-vu/visa-khong-dinh-cu-my-l-1',301);
// });
Route::get('en/united-states-immigration-visa-for-eb-5-investment-program', function(){
    return Redirect::to('en/service/united-states-immigration-visa-for-eb-5-investment-program',301);
});
Route::get('en/non-us-immigration-visa-l-1', function(){
    return Redirect::to('en/service/non-us-immigration-visa-l-1',301);
});


//redirect
$setting = App\Setting::where('name','redirect')->first();
if($setting){
    $arr = unserialize($setting->value);
    foreach($arr['old-link'] as $key=> $value){
        $valuecut = str_replace('http://www.usis.us/','',$value);
        $valuecut = str_replace('https://www.usis.us/','',$valuecut);
        $valuecut = str_replace('http://usis.us/','',$valuecut);
        $valuecut = str_replace('https://usis.us/','',$valuecut);
        $valuecut = str_replace('.html','',$valuecut);
        // var_dump($valuecut);
        Route::get( $valuecut, 'Admin\SettingController@redirectUrl');
    }
    // die;
}


//redirect bài riêng lẻ
Route::get('/tu-van/{slug}', function($slug){
    return Redirect::to('/huong-dan-dinh-cu-hoa-ky/'.$slug,301);
});
// Route::group(['prefix' => LaravelLocalization::setLocale()], function() {
Route::group(['prefix' => LaravelLocalization::setLocale()], function() {

    /*amp*/
    Route::group(['prefix' => 'amp'], function() {

        Route::get('/', 'AmpController@index')->name('homeamp');
        //gioi-thieu
        // Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'lien-he' : 'contact-us'], function() {
        //     Route::get('/', 'AmpController@lienheFunction')->name('lienhegeamp');
        // });

        //gioi-thieu
        Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'gioi-thieu' : 'about-us'], function() {
            Route::get('{slug}', 'AmpController@showPagegioiThieu')->name('subpageamp');
        });

        Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'dau-tu-dinh-cu' : 'service'], function() {
            Route::get('/', 'AmpController@serive')->name('home-service');
            Route::get('{slug}/{permalink}/{partners}','AmpController@dtAncuChitiet')->name('dtAncuChitietamp');
            Route::get('{slug}/{permalink}','AmpController@level3Dichvu')->name('level3Dichvuamp');
            Route::get('{slug}', 'AmpController@showPageDichVu')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('subpagedvamp');
       
       
        });

        Route::group(['prefix' => (LaravelLocalization::setLocale()== '') ? 'du-an-dau-tu-eb-5' : 'eb-5-projects'], function() {
            Route::get('/', 'AmpController@projects')->name('projects-amp');
            Route::get('/{slug}', 'AmpController@showPageDuAn')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('projects-Details-amp');
        });

        //doitac detail
        Route::get((LaravelLocalization::setLocale() =='') ? 'doi-tac/{slug}' : 'partners'.'/{slug}','AmpController@doitacDetail')->name('doitacDetailamp');

        Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'su-kien' : 'events'], function() {
            Route::get('/{slug}', 'AmpController@events')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('subeventsamp');  
            Route::get('/{slug}{suffix}', 'AmpController@eventsDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('eventsnewsDetailamp');
        });

        Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'cuoc-song-tai-my' : 'life-in-america'], function() {
            Route::get('/', 'AmpController@life')->name('lifeamp');
            Route::get('/{slug}', 'AmpController@life')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('sublifeamp');
            Route::get('/{slug}{suffix}', 'AmpController@lifeDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('lifeDetailamp');
        });

        Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'tin-tuc-usis' : 'news'], function() {
            // Route::get('/', 'SiteController@news')->name('news');
            Route::get('/{slug}', 'AmpController@news')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('subnewsamp');
            Route::get('/{slug}{suffix}', 'AmpController@newsDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('newsDetailamp');
        });

        Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'huong-dan-dinh-cu-hoa-ky' : 'u.s.-immigrants-guidebook'], function() {
            Route::get('/', 'AmpController@huongdandinhcu')->name('huongdandinhcuamp');
            Route::get('/{slug}', 'AmpController@hddcDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('hddcDetailamp');
        });
        
        Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'luat-di-tru' : 'regulator-law'], function() {
            Route::get('/', 'AmpController@laws')->name('lawsamp');
            Route::get('/{slug}', 'AmpController@lawsDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('lawsDetailamp');
        });

        Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'cau-hoi-thuong-gap' : 'faqs'], function() {
            // Route::get('/', 'SiteController@faqs')->name('faqs');
            Route::get('/{slug}', 'AmpController@faqs')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('subfaqsamp');
        });

        Route::get((LaravelLocalization::setLocale() =='') ? '/tim-kiem' : '/search','AmpController@search')->name('searchamp');

        Route::group(['prefix' => (LaravelLocalization::setLocale()== '') ? 'cam-nhan-khach-hang' : 'testimonials'], function() {
            Route::get('/', 'AmpController@customer')->name('customeramp');
            Route::get('/{slug}', 'AmpController@customerDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('cus-Detailsamp');
        });
        Route::get('/hoi-dong/{slug}','AmpController@hoidongDetail')->name('hoidongDetail');
        
        //route tag
        Route::get('/tags/{slug}','AmpController@tags')->name('tags');

        Route::get('{slug}', 'AmpController@showPage')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('pagenosubfixamp');

    });
    /*end amp*/

    //sitemap
    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'du-an-sitemap.xml' : 'projects-sitemap.xml'], function() {
        Route::get('/','SiteController@pageSiteMap');
    });
    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'su-kien-sitemap.xml' : 'events-sitemap.xml'], function() {
        Route::get('/','SiteController@pageSiteMap');
    });
    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'doi-tac-sitemap.xml' : 'partners-sitemap.xml'], function() {
        Route::get('/','SiteController@pageSiteMap');
    });
    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'tin-tuc-sitemap.xml' : 'news-sitemap.xml'], function() {
        Route::get('/','SiteController@pageSiteMap');
    });

    // Route::get('du-an-sitemap.xml','SiteController@pageSiteMap');
    // Route::get('su-kien-sitemap.xml','SiteController@pageSiteMap');
    // Route::get('doi-tac-sitemap.xml','SiteController@pageSiteMap');
    // Route::get('tin-tuc-sitemap.xml','SiteController@pageSiteMap');
    Route::get('landing-sitemap.xml','SiteController@pageSiteMap');
    Route::get('sitemap.xml','SiteController@siteMap')->name('sitemap');
    
    Route::get('/', 'SiteController@index')->name('home');
    // Route::get('/lien-he', 'ContactController@contact')->name('contact');
    // Route::post('/lien-he', 'ContactController@contact')->name('contact_send');
    Route::post('/contactUs', 'ContactController@contactUs')->name('contactUs');

    //download file
    Route::post('/downloadFile', 'ContactController@downloadFile')->name('downloadFile');

    //route tag
    Route::get('/tags/{slug}','SiteController@tags')->name('tags');

    // Route::get('/doi-ngu', 'SiteController@usisTeam')->name('usisTeam');
    // Route::get('/usis-team', 'SiteController@usisTeam')->name('usisTeam');
    Route::get('testimonials.html','SiteController@customer')->name('encustomerhtml');
    Route::group(['prefix' => (LaravelLocalization::setLocale()== '') ? 'cam-nhan-khach-hang' : 'testimonials'], function() {
        Route::get('/', 'SiteController@customer')->name('customer');
        Route::get('/{slug}', 'SiteController@customerDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('cus-Details');
    });

    // Route::group(['prefix' => (LaravelLocalization::setLocale()== '') ? 'du-an-dau-tu-eb-5.html' : 'eb-5-projects.html'], 'SiteController@projects')->name('projectshtml');
   

    Route::group(['prefix' => (LaravelLocalization::setLocale()== '') ? 'du-an' : 'eb5-projects'], function() {
        Route::get('/', 'SiteController@projects')->name('eb5-projects');
       // Route::get('/{slug}', 'SiteController@projectDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('projects-Details');
        Route::get('/{slug}', 'SiteController@showPageDuAn')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('projects-Details');
    });

    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'gioi-thieu' : 'about-us'], function() {
        Route::get('{slug}', 'SiteController@showPagegioiThieu')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('subpage');
    });

    //test route
    // Route::get('{slug}','SiteController@showPagegioiThieu')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('subpage');


    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'dich-vu' : 'service'], function() {
        
        Route::get('/', 'SiteController@serive')->name('home-service');
        Route::get('{slug}/{permalink}/{partners}','SiteController@dtAncuChitiet')->name('dtAncuChitiet');
        Route::get('{slug}/{permalink}','SiteController@level3Dichvu')->name('level3Dichvu');
        Route::get('{slug}', 'SiteController@showPageDichVu')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('subpagedv');
        
     
    });



    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'cau-hoi-thuong-gap' : 'faqs'], function() {
        // Route::get('/', 'SiteController@faqs')->name('faqs');
        Route::get('/{slug}', 'SiteController@faqs')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('subfaqs');
    });

    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'tin-tuc-usis' : 'news'], function() {
        // Route::get('/', 'SiteController@news')->name('news');
        Route::get('/{slug}', 'SiteController@news')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('subnews');
        Route::get('/{slug}{suffix}', 'SiteController@newsDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('newsDetail');
    });
    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'cuoc-song-tai-my' : 'life-in-america'], function() {
        Route::get('/', 'SiteController@life')->name('life');
        Route::get('/{slug}', 'SiteController@life')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('sublife');
        Route::get('/{slug}{suffix}', 'SiteController@lifeDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('lifeDetail');
    });

    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'su-kien' : 'events'], function() {
        // Route::get('/', 'SiteController@events')->name('events');
        Route::get('/{slug}', 'SiteController@events')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('subevents');  
        Route::get('/{slug}{suffix}', 'SiteController@eventsDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('eventsnewsDetail');
    });

    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'luat-di-tru' : 'regulator-law'], function() {
        Route::get('/', 'SiteController@laws')->name('laws');
        Route::get('/{slug}', 'SiteController@lawsDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('lawsDetail');
    });

    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'huong-dan-dinh-cu-hoa-ky' : 'u.s.-immigrants-guidebook'], function() {
        Route::get('/', 'SiteController@huongdandinhcu')->name('huongdandinhcu');
        Route::get('/{slug}', 'SiteController@hddcDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('hddcDetail');
        // Route::get('/{slug}.html', 'SiteController@hddcDetail')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('hddcDetailhtml');
    });
    

    Route::get('form/xac-nhan-dang-ky-tu-van-eb5','SiteController@formXacNhan')->name('formXacNhan');
    Route::get('cam-on/cam-on-dang-ky-tu-van-eb5','SiteController@thanksforregis')->name('formXacNhan');

    
    Route::get('loginJLB', 'Admin\LoginController@showLoginForm')->name('login_admin');
    Route::post('loginJLB', 'Admin\LoginController@login');

    //doitac detail
    Route::get((LaravelLocalization::setLocale() =='') ? 'doi-tac/{slug}' : 'partners'.'/{slug}','SiteController@doitacDetail')->name('doitacDetail');

    //  Chi tiết hội đồng
    Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'hoi-dong' : 'assembly'], function() {
        Route::get('/{slug}','SiteController@hoidongDetail')->name('hoidongDetail');
    });
    

    // Route::get('/nguoi-dai-dien/{slug}.html','SiteController@daidienDetail')->name('daidienDetailhtml');
    // Route::get('/nguoi-dai-dien/{slug}','SiteController@daidienDetail')->name('daidienDetail');

    //doi tac an cu chi tiet
    // Route::get('/doi-tac-an-cu/{slug}','SiteController@dtAncuChitiet')->name('dtAncuChitiet');
    

    //chi tiet hoat dong an cu
    Route::get('/hoat-dong-an-cu/{slug}','SiteController@hdAncuChitiet')->name('hdAncuChitiet');

    //tìm kiếm
    // Route::group(['prefix' => (LaravelLocalization::setLocale() == '') ? 'tim-kiem' : 'search'], function() {
    //         Route::get('/', 'SiteController@search')->name('search');
    // });
    Route::get((LaravelLocalization::setLocale() =='') ? '/tim-kiem' : '/search','SiteController@search')->name('search');

    Route::post('/dang-tim-kiem','SiteController@searching')->name('searching');



    // Route::resource('customer', 'Auth\CustomerController', ['only' => 'update']);
    // Route::get('{slug}.html', 'SiteController@showPage')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('pagenosubfix');
    Route::get('{slug}', 'SiteController@showPage')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('pagenosubfix');
    // Route::get('{slug}{suffix}', 'SiteController@showPage')->where('slug', '^(?!api\/)([A-Za-z0-9\-\/]+)')->name('page');

    if (str_contains(Request::path(), '@dmin')) {
        require base_path('routes/admin.php');
    }
});


