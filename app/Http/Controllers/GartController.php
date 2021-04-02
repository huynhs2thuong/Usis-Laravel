<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Dish;
use App\Events\GartUpdated;
use App\Events\MemberUpdated;
use Auth;
use Cache;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Session;

class GartController extends Controller {
    protected $user = null;

    public function __construct() {
        $this->middleware('auth.customer');
    }

    public function index($gartId) {
        $rows = [];
        $users = Cache::get("gart.$gartId.users", []);
        foreach (Cart::content()->reverse() as $item) {
            $options = [];
            foreach ($item->options as $side) {
                $options[] = [
                    'id' => $side->id,
                    'title' => $side->name,
                    'qty' => 1,
                    'price' => $side->price
                ];
            }
            $rows[] = [
                'id' => $item->id,
                'rowId' => $item->rowId,
                'title' => $item->name,
                'qty' => $item->qty,
                'price' => $item->price,
                'options' => $options
            ];
        }
        return response()->json([
            'data'       => $rows,
            'usersCount' => count($users),
            'status'     => $users[$this->user()->id]
        ]);
    }

    public function store(Request $request, $gartId) {
        $id = (int) $request->id;
        $dish = Cache::remember("dish.$id", 1440, function() use($id) {
            return Dish::findOrFail($id);
        });
        # Nếu là combo
        if ($request->has('ids')) {
            $side_dishes = [];
            foreach ($request->ids as $value) {
                $side_dish = 'side_dish_' . $value;
                $$side_dish = Cache::remember("dish.$value", 1440, function() use($value) {
                    return Dish::findOrFail($value);
                });
                $$side_dish->name = $$side_dish->getOriginal('title');
                $dish->price = ($dish->price + $$side_dish->price) / (100 - $dish->discount) * 100;
                $side_dishes[] = $$side_dish;
            }
            Cart::add($dish, 1, $side_dishes)->associate('App\Dish');
        } else {
            Cart::add($dish, 1)->associate('App\Dish');
        }
        $this->updateGroup($gartId);

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request, $gartId, $rowId) {
        Cart::update($rowId, (int) $request->qty);
        $this->updateGroup($gartId);
        return response()->json(['status' => 'success']);
    }

    public function destroy($gartId, $rowId) {
        Cart::remove($rowId);
        $this->updateGroup($gartId);
        return response()->json(['status' => 'success']);
    }

    public function member(Request $request , $gartId) {
        if ($request->method() === 'POST') {
            $users = Cache::get("gart.$gartId.users", []);
            $users[$this->user()->id] = true;
            Cache::put("gart.$gartId.users", $users, config('cart.gartTimeout'));
            event(new GartUpdated((object) ['id' => $gartId, 'value' => count(Cache::get("gart.$gartId.users", []))]));
            return response()->json(['status' => 'success']);
        }
        $rows = [];
        $users = Cache::get("gart.$gartId.users", []);
        $customers = Customer::whereIn('id', array_keys($users))->get()->keyBy('id')->all();
        foreach ($users as $userId => $status) {
            $rows[] = [
                'id' => $userId,
                'name' => $customers[$userId]->name,
                'avatar' => $customers[$userId]->avatar,
                'count' => Cache::get("gart.$gartId.users.$userId")->sum('qty'),
                'status' => $status
            ];
        }
        return response()->json($rows);
    }

    public function memberUpdate(Request $request, $gartId) {
        $action = $request->action;
        $userId = $request->userId;
        if ($action === 'destroy') {
            $users = Cache::get("gart.$gartId.users", []);
            unset($users[$userId]);
            Cache::put("gart.$gartId.users", $users, config('cart.gartTimeout'));
            Cache::forget("gart.$gartId.users.$userId");
        }
        event(new MemberUpdated((object) [
            'gartId' => $gartId,
            'userId' => $userId,
            'action' => $action
        ]));
    }

    public function data($gartId) {
        $rows = [];
        $userIds = array_keys(Cache::get("gart.$gartId.users", []));
        foreach ($userIds as $userId) {
            foreach (Cache::get("gart.$gartId.users.$userId") as $item) {
                $row_id = $item->id;
                $options = [];
                foreach ($item->options as $side) {
                    $options[] = [
                        'id' => $side->id,
                        'title' => $side->name,
                        'qty' => 1,
                        'price' => $side->price
                    ];
                    $row_id .= $side->id;
                }
                if (array_key_exists($row_id, $rows)) {
                    $rows[$row_id]['qty'] += $item->qty;
                    continue;
                }
                $rows[$row_id] = [
                    'id' => $item->id,
                    'rowId' => $item->rowId,
                    'title' => $item->name,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'options' => $options
                ];
            }
        }
        return response()->json($rows);
    }

    public function checkout(Request $request, $gartId) {
        if (!$this->checkTimeServe()) {
            Session::flash('response', ['status' => 'error', 'message' => trans('user.message.time')]);
            return redirect()->action('GroupController@index');
        }
        # Authorize
        if (!$this->user()->can('group-owner', $gartId)) abort(404);
        $extras = Dish::whereHas('groups', function($query) {
            $query->withoutGlobalScopes()->where('slug', 'extra');
        })->get();
        return view('site.checkout.group', ['extras' => $extras, 'gartId' => $gartId]);
    }

    protected function updateGroup($gartId) {
        Cache::put("gart.$gartId.users.{$this->user()->id}", Cart::content(), config('cart.gartTimeout'));
    }

    protected function user() {
        return Auth::guard('customer')->user();
    }

    protected function checkTimeServe() {
        # Kiểm tra thời gian phục vụ
        $start = Carbon::today()->addMinutes(config('cart.timeCheckout.start') * 60);
        $end = Carbon::today()->addMinutes(config('cart.timeCheckout.end') * 60);
        return Carbon::now()->between($start, $end);
    }
}
