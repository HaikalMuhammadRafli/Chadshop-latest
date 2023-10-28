<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function payment_handler(Request $request) {
        $json = json_decode($request->getContent());
        $sigature_key = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . env('MIDTRANS_SERVER_KEY'));
        
        if ($sigature_key != $json->signature_key) {
            return abort(404);
        }

        $order = Cart::where('no_invoice', $json->order_id)->first();
        return $order->update(['status_pembayaran' => $json->transaction_status]);
    }
}
