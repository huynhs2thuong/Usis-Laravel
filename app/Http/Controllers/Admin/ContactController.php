<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() {
    	$contacts = Contact::orderBy('id', 'desc')->take(100)->get();
    	return view('admin.contact.index', compact('contacts'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:3|max:255',
            'phone' => 'required|digits_between:10,15',
            'email' => 'required|email',
            'message' => 'required|min:3'
        ]);
        try {
            Contact::create($request->all());
            return response()->json(['status' => 'success', 'message' => trans('user.contact.success')]);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => trans('user.contact.error')]);
        }
    }

    public function destroy($id) {
    	Contact::destroy($id);
        return response()->json(['status' => 'success', 'message' => trans('admin.message.delete')]);
    }

    public function export() {
        header('Content-Encoding: UTF-8');
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=Lien-he_' . date('d-m-Y-H-i-s') . '.csv');
        echo "\xEF\xBB\xBF"; // UTF-8 BOM
    	$contacts = Contact::orderBy('id', 'desc')->get(['name', 'email', 'phone', 'message', 'created_at'])->toArray();
        $output = fopen('php://output', 'w');
        foreach ($contacts as $contact) {
            fputcsv($output, $contact);
        }
        fclose($output);
        return;
    }
}
