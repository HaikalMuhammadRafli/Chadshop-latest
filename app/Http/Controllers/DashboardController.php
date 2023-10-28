<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\EventDetail;
use App\Models\ProdukPromo;
use App\Models\CartDetail;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $itemuser = $request->user();

        $itemproduk = Produk::where('user_id', $itemuser->id)->get();
        $produkcount = count($itemproduk);

        $promo = ProdukPromo::where('user_id', $itemuser->id)->count();
        $evented = EventDetail::where('user_id', $itemuser->id)->count();
        $pesanan = CartDetail::whereHas('produk', function($q) use ($itemuser) {
            $q->where('status', 'publish');
            $q->where('user_id', $itemuser->id);
        })
        ->count();

        $itemnewproduk = Produk::where('user_id', $itemuser->id)->orderBy('created_at', 'desc')->paginate(10);

        $data = array('title' => 'Dashboard',
                    'produkcount' => $produkcount,
                    'itemnewproduk' => $itemnewproduk,
                    'itemproduk' => $itemproduk,
                    'promo' => $promo,
                    'evented' => $evented,
                    'pesanan' => $pesanan);
        return view('dashboard.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }
}
