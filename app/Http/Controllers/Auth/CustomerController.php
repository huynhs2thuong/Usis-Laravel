<?php

namespace App\Http\Controllers\Auth;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.customer');
    }

    public function update(Request $request, $id) {
    	$this->validate($request, [
            'password' => 'min:6|confirmed',
        ]);
        $customer = Customer::findOrFail($id);
        $customer->update(['password' => bcrypt($request->password)]);
    	return response()->json(['status' => 'success', 'message' => trans('passwords.reset')]);
    }
}
