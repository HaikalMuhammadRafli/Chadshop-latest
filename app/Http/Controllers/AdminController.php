<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\About;
use App\Models\User;
use App\Models\Order;
use App\Models\Event;

class AdminController extends Controller
{
    public function index(Request $request) {
        $itemuser = $request->user();

        $itemevent = Event::where('user_id', $itemuser->id)->orderBy('created_at', 'desc')->where('status', 'aktif')->paginate(10);

        $member = User::where('role', 'member')->count();
        $seller = User::where('role', 'seller')->count();
        $order = Order::whereHas('cart', function($q) use ($itemuser) {
            $q->where('status_cart', 'checkout');
        })
        ->count();
        $event = Event::where('user_id', $itemuser->id)->count();

        $data = array('title' => 'Admin',
                    'itemevent' => $itemevent,
                    'member' => $member,
                    'seller' => $seller,
                    'order' => $order,
                    'event' => $event);
        return view('admin.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }
}
