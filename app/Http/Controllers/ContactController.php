<?php

namespace App\Http\Controllers;

use App\Page;
use App\Form;
use App\Mail\ContactMail;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use App\Contact;

class ContactController extends Controller
{
    public function __construct() {
        Page::addGlobalScope(new ActiveScope);
    }

    public function contact(Request $request, $slug = 'lien-he') {
        $page = Page::where('slug', $slug)->firstOrFail();
        if(!$page){
            abort(404);
        }
                
        return view('site.page.contact',compact('page'));
    }

    public function sendmail(Request $request)
    {
        $rules = [
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'name' => 'required|string',
        ];
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'type' => $request->type
        ];
        var_dump(json_encode($request->all()));die();
        // if (array_key_exists('g-recaptcha-response', $request->all())) {
        //     $rules['g-recaptcha-response'] = 'required';
        //     $siteKeyPost = $request['g-recaptcha-response'];
        // } elseif (array_key_exists('message', $request->all())) {
        //     $rules['message'] = 'required|string';
        // }
        // $this->validate($request, $rules);

        // if (!empty($siteKeyPost)) {
        //     if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //     $remoteIp = $_SERVER['HTTP_CLIENT_IP'];
        //     } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //         $remoteIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        //     } else {
        //         $remoteIp = $_SERVER['REMOTE_ADDR'];
        //     }
        //     $apiUrl = env('CAPCHA_API_URL') . '?secret=' . env('CAPCHA_SITE_KEY') . '&response=' . $siteKeyPost;
        //     $response = file_get_contents($apiUrl);
        //     $response = json_decode($response);
        //     if (!isset($response->success)) {
        //         return back([
        //             'errors' => [
        //                 'g-recaptcha-response' => trans('property.error_captcha')
        //             ]
        //         ]);
        //     }
        // }
        // if (!empty($request->message)) {
        //     $data['message'] = $request->message;
        // }

        $email = Email::where('type', $contact->type)->first();
        if (!empty($email)) {
            $to = [
                'address' => $contact->email,
                'name' => $contact->name
            ];
            $cc = explode(',', $contact->cc);
            $bcc = explode(',', $contact->bcc);
            $this->sendRawEmail($contact->content, $to, $cc, $bcc, $contact->subject);
        }
        session()->flash('message', "message sent successfully");
        return redirect()->back();
    }
    public function contactUs(Request $request){
        //ajax lưu contact
        // var_dump('a');die;
        if ($request->ajax()) {
               $value['name'] = $_POST['name'];
                $value['email'] = $_POST['email'];
                $value['phone'] = $_POST['phone'];
                $value['message'] = $_POST['message'];
                $value = $request->all();
                if(!empty($value["created_at"])){
                    $value["created_at"] = explode('/',$value["created_at"]);
                    $temp = $value["created_at"][0];
                    $value["created_at"][0] = $value["created_at"][1];
                    $value["created_at"][1] = $temp;
                    $value["created_at"] = implode('/',$value["created_at"]);
                    $value["created_at"] = Carbon::parse($value["created_at"])->format('Y-m-d H:i:s');
                }
                $new = Contact::create($value);
                $getreturn = "success";
                //goi mail toi support@retailpartner.vn 
                // $maildata = ['content'=> 'email->content', 'contact' => $new, 'confirm_url' => "#"];

                // $to = [
                //     'address' => 'support@retailpartner.vn',
                //     'name' => 'H:CONNECT'
                // ];
                // $cc = '';//explode(',', $email->cc);
                // $bcc = '';//explode(',', $email->bcc);
                // $this->sendContactEmail($maildata, $to, $cc, $bcc,":Lien He from H:CONNECT");
                return response()->json(compact('getreturn')); 
        }
        // if(SHOWMOBILE){
        //     //title for heacher
        //     $titleHeader = Lang::get('page.contact_us');
        //     return view('mobile.contact',compact('titleHeader','mobile'));
        // }
    }

}