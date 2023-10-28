<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\AlamatPengiriman;
use App\Models\Order;
use App\Models\Produk;
use App\Models\CartDetail;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();//ambil data user
        $itemcart = Cart::where('user_id', $itemuser->id)
                        ->where('status_cart', 'cart')
                        ->first();
        if ($itemcart) {
            $data = array('title' => 'Shopping Cart',
                        'itemcart' => $itemcart);
            return view('cart.index', $data)->with('no', 1);
        } else {
            $no_invoice = Cart::where('user_id', $itemuser->id)->count();
            //nyari jumlah cart berdasarkan user yang sedang login untuk dibuat no invoice
            $input['user_id'] = $itemuser->id;
            $input['no_invoice'] = 'INV '.str_pad(($no_invoice + 1),'3', '0', STR_PAD_LEFT);
            $input['status_cart'] = 'cart';
            $input['status_pembayaran'] = 'belum';
            $input['status_pengiriman'] = 'belum';
            $input['status_penerimaan'] = 'belum';
            $itemcart = Cart::create($input);
            $data = array('title' => 'Shopping Cart',
                        'itemcart' => $itemcart);
            return view('cart.index', $data)->with('no', 1);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
    public function kosongkan($id) {
        $itemcart = Cart::findOrFail($id);
        $itemcart->detail()->delete();//hapus semua item di cart detail
        $itemcart->updatetotal($itemcart, '-'.$itemcart->subtotal);
        return back()->with('success', 'Cart berhasil dikosongkan');
    }
    public function checkout(Request $request) {
        $itemuser = $request->user();
        $itemcart = Cart::where('user_id', $itemuser->id)
                        ->where('status_cart', 'cart')
                        ->first();
        $itemcount = CartDetail::where('cart_id', $itemcart->id)
                                ->count();
        $itemalamatpengiriman = AlamatPengiriman::where('user_id', $itemuser->id)
                                                ->where('status', 'utama')
                                                ->first();
        if ($itemcart) {
            if ($itemcount >= 1) {
                $data = array('title' => 'Checkout',
                        'itemcart' => $itemcart,
                        'itemalamatpengiriman' => $itemalamatpengiriman);
                return view('cart.checkout', $data)->with('no', 1);
            } else {
                return back()->with('error', 'Belum ada produk yang ditambahkan!');
            }     
        } else {
            return abort('404');
        }
    }

    public function buynow(Request $request) {
        $itemuser = $request->user();

        $itemcarto = Cart::where('user_id', $itemuser->id)->where('status_cart', 'cart')->first();
        if ($itemcarto) {
            $itemcarto->detail()->delete();//hapus semua item di cart detail
            $itemcarto->updatetotal($itemcarto, '-'.$itemcarto->subtotal);
        }

        $this->validate($request, [
            'produk_id' => 'required',
        ]);
        $itemuser = $request->user();
        $itemproduk = Produk::findOrFail($request->produk_id);
        // cek dulu apakah sudah ada shopping cart untuk user yang sedang login
        $cart = Cart::where('user_id', $itemuser->id)
                    ->where('status_cart', 'cart')
                    ->first();

        if ($cart) {
            $itemcart = $cart;
        } else {
            $no_invoice = Cart::where('user_id', $itemuser->id)->count();
            //nyari jumlah cart berdasarkan user yang sedang login untuk dibuat no invoice
            $inputancart['user_id'] = $itemuser->id;
            $inputancart['no_invoice'] = 'INV '.str_pad(($no_invoice + 1),'3', '0', STR_PAD_LEFT);
            $inputancart['status_cart'] = 'cart';
            $inputancart['status_pembayaran'] = 'belum';
            $inputancart['status_pengiriman'] = 'belum';
            $inputancart['status_penerimaan'] = 'belum';
            $itemcart = Cart::create($inputancart);
        }
        // cek dulu apakah sudah ada produk di shopping cart
        $cekdetail = CartDetail::where('cart_id', $itemcart->id)
                                ->where('produk_id', $itemproduk->id)
                                ->first();
        $qty = 1;// diisi 1, karena kita set ordernya 1
        $harga = $itemproduk->harga;//ambil harga produk
        $diskon = $itemproduk->promo != null ? $itemproduk->promo->diskon_nominal: 0;
        $diskon_event = $itemproduk->eventdetail != null ? $itemproduk->eventdetail->diskon_nominal: 0;
        if ($diskon_event) {
            $subtotal = ($qty * $harga) - $diskon_event;
        } else {
            $subtotal = ($qty * $harga) - $diskon;
        }
        // diskon diambil kalo produk itu ada promo, cek materi sebelumnya
        if ($cekdetail) {
            // update detail di table cart_detail
            if ($diskon_event) {
                $cekdetail->updatedetail($cekdetail, $qty, $harga, $diskon_event);
            } else {
                $cekdetail->updatedetail($cekdetail, $qty, $harga, $diskon);
            }   
            // update subtotal dan total di table cart
            $cekdetail->cart->updatetotal($cekdetail->cart, $subtotal);
        } else {
            $inputan = $request->all();
            $inputan['cart_id'] = $itemcart->id;
            $inputan['produk_id'] = $itemproduk->id;
            $inputan['qty'] = $qty;
            $inputan['harga'] = $harga;
            $inputan['status_pesanan'] = 'menunggu';
            if ($diskon_event) {
                $inputan['diskon'] = $diskon_event;
                $inputan['subtotal'] = ($harga * $qty) - $diskon_event;
            } else {
                $inputan['diskon'] = $diskon;
                $inputan['subtotal'] = ($harga * $qty) - $diskon;
            }
            $itemdetail = CartDetail::create($inputan);
            // update subtotal dan total di table cart
            $itemdetail->cart->updatetotal($itemdetail->cart, $subtotal);
        }
        return redirect('checkout');
    }
}
