<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\AlamatPengiriman;
use App\Models\Order;
use App\Models\Produk;
use App\Models\CartDetail;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
        if ($itemuser->role == 'admin') {
            // kalo admin maka menampilkan semua cart
            $itemorder = Order::whereHas('cart', function($q) use ($itemuser) {
                            $q->where('status_cart', 'checkout');
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);

            $data = array('title' => 'Data Transaksi',
                        'itemorder' => $itemorder,
                        'itemuser' => $itemuser);
            return view('transaksi.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
        } else {
            return back();
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
        $itemuser = $request->user();
        $itemcart = Cart::where('status_cart', 'cart')
                        ->where('user_id', $itemuser->id)
                        ->first();
        if ($itemcart) {
            $itemalamatpengiriman = AlamatPengiriman::where('user_id', $itemuser->id)
                                                    ->where('status', 'utama')
                                                    ->first();
            if ($itemalamatpengiriman) {
                // buat variabel inputan order
                $inputanorder['cart_id'] = $itemcart->id;
                $inputanorder['nama_penerima'] = $itemalamatpengiriman->nama_penerima;
                $inputanorder['no_tlp'] = $itemalamatpengiriman->no_tlp;
                $inputanorder['alamat'] = $itemalamatpengiriman->alamat;
                $inputanorder['provinsi'] = $itemalamatpengiriman->provinsi;
                $inputanorder['kota'] = $itemalamatpengiriman->kota;
                $inputanorder['kecamatan'] = $itemalamatpengiriman->kecamatan;
                $inputanorder['kelurahan'] = $itemalamatpengiriman->kelurahan;
                $inputanorder['kodepos'] = $itemalamatpengiriman->kodepos;
                $itemorder = Order::create($inputanorder);//simpan order
                // update status cart
                $itemcart->update(['status_cart' => 'checkout']);
                return redirect('transaksi_list')->with('success', 'Pesanan Sudah Terkirim!');
            } else {
                return back()->with('error', 'Alamat pengiriman belum diisi');
            }
        } else {
            return abort('404');//kalo ternyata ga ada shopping cart, maka akan menampilkan error halaman tidak ditemukan
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $itemuser = $request->user();
        if ($itemuser->role == 'admin') {
            $itemorder = Order::findOrFail($id);
            $data = array('title' => 'Detail Transaksi',
                        'itemorder' => $itemorder);
            return view('transaksi.show', $data)->with('no', 1);
        } else {
            $itemorder = Order::where('id', $id)
                            ->whereHas('cart', function($q) use ($itemuser) {
                                $q->where('user_id', $itemuser->id);
                            })->first();
            if ($itemorder) {
                $data = array('title' => 'Detail Transaksi',
                            'itemorder' => $itemorder);
                return view('transaksi.show', $data)->with('no', 1);
            } else {
                return abort('404');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $itemuser = $request->user();
        if ($itemuser->role == 'admin') {
            $itemorder = Order::findOrFail($id);
            $data = array('title' => 'Form Edit Transaksi',
                        'itemorder' => $itemorder);
            return view('transaksi.edit', $data)->with('no', 1);
        } else {
            return abort('404');//kalo bukan admin maka akan tampil error halaman tidak ditemukan
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'status_pembayaran' => 'required',
            'status_pengiriman' => 'required',
            'status_penerimaan' => 'required',
            'subtotal' => 'required|numeric',
            'ongkir' => 'required|numeric',
            'diskon' => 'required|numeric',
            'total' => 'required|numeric',
        ]);
        $inputan = $request->all();
        $inputan['status_pembayaran'] = $request->status_pembayaran;
        $inputan['status_pengiriman'] = $request->status_pengiriman;
        $inputan['status_penerimaan'] = $request->status_penerimaan;
        $inputan['subtotal'] = str_replace(',','',$request->subtotal);
        $inputan['ongkir'] = str_replace(',','',$request->ongkir);
        $inputan['diskon'] = str_replace(',','',$request->diskon);
        $inputan['total'] = str_replace(',','',$request->total);
        $itemorder = Order::findOrFail($id);
        $itemorder->cart->update($inputan);
        return back()->with('success','Order berhasil diupdate');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->validate($request, [
            'cart_id' => 'required',
        ]);

        $itemorder = Order::findOrFail($id);
        $itemcart = Cart::findOrFail($request->cart_id);
        if ($itemcart) {
            if ($itemorder) {
                if ($itemcart->detail) {
                    foreach ($itemcart->detail as $detail) {
                        $detail->delete();
                    }
                }
                $itemorder->delete();
            }
            $itemcart->delete();
            return back()->with('success', 'Pesanan berhasil dibatalkan!');
        }
    }

    public function transaksi_list(Request $request) {
        $itemuser = $request->user();
        $itemorder_n_n_n = Order::whereHas('cart', function($q) use ($itemuser) {
            $q->where('status_cart', 'checkout');
            $q->where('status_pembayaran', 'belum');
            $q->where('status_pengiriman', 'belum');
            $q->where('status_penerimaan', 'belum');
            $q->where('user_id', $itemuser->id);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $itemorder_y_n_n = Order::whereHas('cart', function($q) use ($itemuser) {
            $q->where('status_cart', 'checkout');
            $q->where('status_pembayaran', 'sudah');
            $q->where('status_pengiriman', 'belum');
            $q->where('status_penerimaan', 'belum');
            $q->where('user_id', $itemuser->id);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $itemorder_y_y_n = Order::whereHas('cart', function($q) use ($itemuser) {
            $q->where('status_cart', 'checkout');
            $q->where('status_pembayaran', 'sudah');
            $q->where('status_pengiriman', 'sudah');
            $q->where('status_penerimaan', 'belum');
            $q->where('user_id', $itemuser->id);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $itemorder_y_y_y = Order::whereHas('cart', function($q) use ($itemuser) {
            $q->where('status_cart', 'checkout');
            $q->where('status_pembayaran', 'sudah');
            $q->where('status_pengiriman', 'sudah');
            $q->where('status_penerimaan', 'sudah');
            $q->where('user_id', $itemuser->id);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);


        $data = array('title' => 'Daftar Transaksi',
                    'itemorder_n_n_n' => $itemorder_n_n_n,
                    'itemorder_y_n_n' => $itemorder_y_n_n,
                    'itemorder_y_y_n' => $itemorder_y_y_n,
                    'itemorder_y_y_y' => $itemorder_y_y_y,
                    'itemuser' => $itemuser);
        return view('transaksi.list', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }

    public function transaksi_detail(Request $request, $id) {
        $itemuser = $request->user();
        $itemorder = Order::where('id', $id)
                            ->whereHas('cart', function($q) use ($itemuser) {
                                $q->where('user_id', $itemuser->id);
                            })->first();
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-QFVvOKrcovyjyi21jAzp3Pse';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        
        if ($itemorder->cart->token == null) {
            $params = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => $itemorder->cart->subtotal,
                ),
                'customer_details' => array(
                    'first_name' => $itemuser->name,
                    'last_name' => '',
                    'email' => $itemuser->email,
                    'phone' => $itemuser->phone,
                ),
            );
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $itemorder->cart->update(['token' => $snapToken]);
        } else {
            $snapToken = $itemorder->cart->token;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/$itemorder->cart->no_invoice/status",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS =>"\n\n",
          CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: "
          ),
        ));
        
        $response = curl_exec($curl);   
        curl_close($curl);
        $json = json_decode($response);
        if ($json->status_code != '404') {
            $itemorder->cart->update(['status_pembayaran' => 'sudah']);
        }
        if ($itemorder) {
            $data = array('title' => 'Detail Transaksi',
                        'itemorder' => $itemorder,
                        'snap_token' => $snapToken);
            return view('transaksi.detail', $data)->with('no', 1);
        } else {
            return abort('404');
        }
    }

    public function pesanan(Request $request) {
        $itemuser = $request->user();
        $itemproduk = Produk::where('user_id', $itemuser->id);

        $itempesanan = CartDetail::whereHas('produk', function($q) use ($itemuser) {
            $q->where('status', 'publish');
            $q->where('user_id', $itemuser->id);
        })
        ->paginate(20);

        $data = array('title' => 'Pesanan',
                'itemuser' => $itemuser,
                'itempesanan' => $itempesanan);
        return view('transaksi.pesanan', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }

    public function pesanandetail(Request $request, $id)
    {
        $itemuser = $request->user();
        $itemorder = Order::findOrFail($id);

        if ($itemorder) {
            $data = array('title' => 'Detail Transaksi',
                        'itemorder' => $itemorder,
                        'itemuser' => $itemuser);
            return view('transaksi.pesanandetail', $data)->with('no', 1);
        } else {
            return abort('404');
        }
    }

    public function kirimpesanan(Request $request) {
        $this->validate($request, [
            'cart_id' => 'required',
            'cartdetail_id' => 'required',
            'produk_id' => 'required',
            'qty_pesanan' => 'required',
            'qty_produk' => 'required',
        ]);

        $itemuser = $request->user();
        $itemcart = Cart::where('id', $request->cart_id);

        $pesanan = CartDetail::where('id', $request->cartdetail_id)
                            ->update(['status_pesanan' => 'terkirim']);
        
        if ($pesanan) {
            $newstock = $request->qty_produk - $request->qty_pesanan;
            $updateproduk = Produk::where('id', $request->produk_id)
                                ->update(['qty' => $newstock]);

            $cekdetail = CartDetail::where('cart_id', $request->cart_id)
                                    ->where('status_pesanan', 'menunggu')
                                    ->count();

            if ($cekdetail == null) {
                $itemcart->update(['status_pengiriman' => 'sudah']);
            }
            
            return back()->with('success', 'Barang sudah terdata!');
        } else {
            return back()->with('error', 'Barang gagal terdata!');
        }
    }

    public function pesananditerima(Request $request) {
        $this->validate($request, [
            'cart_id' => 'required',
        ]);
        
        $itemcart = Cart::findOrFail($request->cart_id)
                        ->update(['status_penerimaan' => 'sudah']);

        if ($itemcart) {
            return back()->with('success', 'Yey, pembelianmu selesai!');
        } else {
            return back()->with('error', 'Error!');
        }
    }
}
