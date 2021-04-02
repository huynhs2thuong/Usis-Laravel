<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Resource;
use App\Dish;
use App\Setting;
use File;
use Session;
use DB;
use App;
use Redirect;

class SettingController extends Controller
{
    private $data;

    public function edit($name) {
    	$this->data['setting'] = Setting::where('name', $name)->firstOrFail();
        $view = $this->{camel_case('edit-' . $name)}($name);
        return view($view, $this->data);
    }

    public function update(Request $request, $name) {
    	$this->{camel_case('update-' . $name)}($request, $name);
		Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.update')]);
        return back();
    }

    private function editHomeBanner($name) {
        return 'admin.setting.home-banner';
    }

    private function updateHomeBanner(Request $request, $name) {
    	$ids = $request->get('images', []);
    	$placeholders = implode(',', array_fill(0, count($ids), '?'));
		$resources = empty($ids) ? [] : Resource::whereIn('id', $ids)->orderByRaw("field(id,{$placeholders})", $ids)->get();
		$images = [];
		foreach ($resources as $resource) {
			$images[] = [
				'id' => $resource->id,
				'url' => $resource->full
			];
		}
		Setting::where('name', $name)->update(['value' => json_encode($images)]);
    }

    private function editHomePromo($name) {
        $dishes = Dish::orderBy('id', 'desc')->get();
        $this->data['dishes'] = $dishes;
        $this->data['promos'] = $dishes->whereIn('id', json_decode($this->data['setting']->value))->keyBy('id')->all();
        return 'admin.setting.home-promo';
    }

    private function updateHomePromo(Request $request, $name) {
        Setting::where('name', $name)->update(['value' => $request->dishes]);
    }

    //setting trong admin
    public function basicSetting(){
        $logofooter = Setting::where('name','logofooter')->first();
        $setting = Setting::where('name','basic')->first();
        $images = [];
        $links = [];
        if($setting){
            $imageIds = unserialize($setting->value);
            // var_dump($imageIds);die;    
            if(is_array($imageIds)){
                foreach ($imageIds[0] as $key => $value) {
                    $image = Resource::where('id',$value)->first();
                    if($image){
                         $images[$key] = $image;
                    }else{
                        $images[$key] = '';
                    }
                   
                }
                if($imageIds[1]){
                    foreach ($imageIds[1] as $key => $value) {
                        $links[$key] = $value;
                    }
                }else{
                    $links[$key] = '';
                }
            }
        }
        // var_dump($links);die;
        return view('admin.setting.basic',compact('setting','images','links','logofooter'));
    }

    //save setting
    public function updateBasic(Request $request){
        $setting = Setting::where('name','basic')->first();
        // var_dump($request->all());die;
        if($setting){
            Setting::destroy($setting->id);
        }
        $value = $request->all();
        $value['name'] = 'basic';
        $value['resource_id'] = $request->resource_id !== '' ? $request->resource_id : NULL ;
        // var_dump($value);die;
        $arrayvalue = [];
        $arrayvalue[0][9] = $request->footer_image9;
        $arrayvalue[0][10] = $request->footer_image10;
        $arrayvalue[0][11] = $request->footer_image11;
        $arrayvalue[0][12] = $request->footer_image12;
        $arrayvalue[1] = $request->url;
        // var_dump($arrayvalue);die;
        $type = 'setting';
        
        $arrayvalue = serialize($arrayvalue);
        $value['value'] = $arrayvalue;
        $setting = Setting::create($value);


        $data['name'] = 'logofooter';

        if($request->logo_footer){
            $data['value'] = '';
            $data['resource_id'] = $request->logo_footer !== '' ? (int) $request->logo_footer : NULL;
        }
        if($request->footerlogourl){
            $data['value'] = $request->footerlogourl;
        }else{
            $data['value'] = '';
        }

        $settingcur = Setting::where('name','logofooter')->first();
        if($settingcur){
            Setting::destroy($settingcur->id);
        }
        
        $setting = Setting::create($data);

        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.create')]);
        return redirect()->action('Admin\SettingController@basicSetting');
    }
    public function removeResource(){
        $setting = Setting::where('name','basic')->update('resource_id',NULL);
        return redirect()->action('Admin\SettingController@basicSetting');
    }

    public function filemanager(){
        return view('admin.setting.filemanager');
    }

    public function redirectLink(Request $request){
        $setting = Setting::where('name','redirect')->first();
        $value = [];
        if($setting){
            $value = unserialize($setting->value);
        }
        $value = array_filter($value);
        return view('admin.setting.redirect',compact('value'));
    }
    public function updateRedirect(Request $request){
        $value = $request->all();
        $arr = [];
        $arr['old-link'] = $value['old-link'];
        $arr['new-link'] = $value['new-link'];
        $seri = serialize($arr);
        $name = 'redirect';
        $setting = Setting::where('name','redirect')->first();
        if(!$setting){
            DB::table('settings')->insert([
                'name'=>$name,
                'value'=> $seri,
                'resource_id' => NULL
            ]);
        }else{
            $setting->update(['value'=>$seri]);
        }
        return redirect()->action('Admin\SettingController@redirectLink');
    }
    public function redirectUrl(Request $request){
        $setting = Setting::where('name','redirect')->first();
        $arr = unserialize($setting->value);
        $fullcur = url()->current();
        $currentlink = str_replace('http://www.usis.us/','',$fullcur);
        $currentlink = str_replace('https://www.usis.us/','',$currentlink);
        $currentlink = str_replace('http://usis.us/','',$currentlink);
        $currentlink = str_replace('https://usis.us/','',$currentlink);
        $currentlink = str_replace('http://usis2.test/','',$currentlink);
        $currentlink = str_replace('–','%e2%80%93',$currentlink);
        $currentlink = str_replace('.html','',$currentlink);
        foreach($arr['old-link'] as $key=>$value){
            $newlink = $arr['new-link'][$key];
            $valuecut = str_replace('http://www.usis.us/','',$value);
            $valuecut = str_replace('https://www.usis.us/','',$valuecut);
            $valuecut = str_replace('http://usis.us/','',$valuecut);
            $valuecut = str_replace('https://usis.us/','',$valuecut);
            $valuecut = str_replace('.html','',$valuecut);
            $valuecut = str_replace('–','%e2%80%93',$valuecut);
            $newlink = str_replace('https://usis.us/','',$newlink);
            $newlink = str_replace('http://usis.us/','',$newlink);
            $newlink = str_replace('https://www.usis.us/','',$newlink);
            $newlink = str_replace('http://www.usis.us/','',$newlink);
            $newlink = str_replace('.html','',$newlink);
            // var_dump($currentlink);var_dump($valuecut);die;
            if($valuecut == $currentlink){
                // return redirect()->to($newlink);
               return redirect($newlink);
            }
            
        }
    }
}
