<?php

namespace App\Http\Controllers\Admin;

use App\Form;
use App\Http\Requests\SaveMail;
use App\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class MailController extends Controller
{
    public function update(SaveMail $request, $id)
    {
        $mail = Mail::findOrFail($id);
        $mail->update($request->all());
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.update')]);
        return back();
    }

    public function store(SaveMail $request)
    {
        $id_form = $request->get('form_id');
        $mail = Mail::create($request->all());
        Session::flash('response', ['status' => 'success', 'message' => trans('admin.message.create')]);
        return redirect()->action('Admin\FormController@edit', $id_form);
    }
}
