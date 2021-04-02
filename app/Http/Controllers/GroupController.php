<?php

namespace App\Http\Controllers;

use Agent;
use App\Dish;
use App\Events\GartUpdated;
use App\Group;
use Auth;
use Cache;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function __construct() {
        $this->middleware('auth.customer', ['only' => 'getShareLink']);
    }

	public function index(Request $request) {
		$group = Group::has('dishes')->where('is_side', false)->orderBy('created_at', 'desc')->first();
        $request->session()->reflash();
        return ($request->has('gartId')) ? redirect()->action('GroupController@showGart', [$group->slug, $request->gartId])
            : redirect()->action('GroupController@show', $group->slug);

	}

    public function show($slug) {
    	$group = Group::withoutGlobalScope('public')->where(['is_side' => false, 'slug' => $slug])->firstOrFail();
    	$group->load('dishes.resource');
        $groups = Cache::remember('groups.main', 1440, function() {
            return Group::withCount('dishes')->where('is_side', false)->orderBy('created_at', 'desc')->get();
        });
        if (!$this->checkTimeServe()) {
            Session::flash('response', ['status' => 'error', 'message' => trans('user.message.time')]);
        }
    	return view(Agent::isPhone() ? 'site.order.mobile' : 'site.order.normal', compact('group', 'groups'));
    }

    public function showGart($slug, $gartId) {
        if (!Cache::has("gart.$gartId.owner")) return redirect()->action('GroupController@show', $slug);
        $group = Group::where(['is_side' => false, 'slug' => $slug])->firstOrFail();
        $group->load('dishes.resource');
        $isOwner = false;
        if (Auth::guard('customer')->check()) {
            if (Auth::guard('customer')->user()->can('group-owner', $gartId)) $isOwner = true;
            $users = Cache::get("gart.$gartId.users", array());
            $user_id = Auth::guard('customer')->user()->id;
            if (!in_array($user_id, array_keys($users))) {
                $users[$user_id] = false;
                Cache::put("gart.$gartId.users", $users, config('cart.gartTimeout'));
                Cache::put("gart.$gartId.users.$user_id", Cart::content(), config('cart.gartTimeout'));
                $gart = (object) ['id' => $gartId, 'value' => count(Cache::get("gart.$gartId.users", []))];
                event(new GartUpdated($gart));
            }
        }
        $groups = Cache::remember('groups.main', 1440, function() {
            return Group::has('dishes')->where('is_side', false)->orderBy('created_at', 'desc')->get();
        });
        return view('site.order.group', compact('group', 'groups', 'gartId', 'isOwner'));
    }

    public function getShareLink($slug) {
        do {
            $id = Str::quickRandom();
        } while (Cache::has("gart.$id"));
        $user_id = Auth::guard('customer')->user()->id;
        Cache::put("gart.$id.owner", $user_id, config('cart.gartTimeout'));
        Cache::put("gart.$id.users", [$user_id => true], config('cart.gartTimeout'));
        Cache::put("gart.$id.users.$user_id", Cart::content(), config('cart.gartTimeout'));

        return redirect()->action('GroupController@showGart', [$slug, $id]);
    }

    protected function checkTimeServe() {
        # Kiểm tra thời gian phục vụ
        $start = Carbon::today()->addMinutes(config('cart.timeCheckout.start') * 60);
        $end = Carbon::today()->addMinutes(config('cart.timeCheckout.end') * 60);
        return Carbon::now()->between($start, $end);
    }

}
