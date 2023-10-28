<?php

namespace App\Http\Controllers;

use App\Models\EventDetail;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Produk;
use App\Models\ProdukPromo;

class EventDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemevent = Event::orderBy('created_at', 'desc')->paginate(20);
        $itemeventdetail = EventDetail::orderBy('created_at', 'desc')->paginate(20);
        $data = array('title' => 'Produk Event Diskon',
                    'itemeventdetail' => $itemeventdetail,
                    'itemevent' => $itemevent);
        return view('eventdetail.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $itemuser = $request->user();
        $cekpromo = ProdukPromo::where('user_id', $itemuser->id)->get();
        $itemevent = Event::all();
        $cekeventdetail = EventDetail::all();
        $itemproduk = Produk::where('user_id', $itemuser->id)
                            ->get();
        $data = array('title' => 'Form Produk Event',
                        'itemevent' => $itemevent,
                        'itemproduk' => $itemproduk);
        return view('eventdetail.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'event_id' => 'required',
            'produk_id' => 'required',
            'harga_awal' => 'required',
            'harga_akhir' => 'required',
            'diskon_persen' => 'required',
            'diskon_nominal' => 'required',
        ]);
        $cekeventdetail = EventDetail::where('produk_id', $request->produk_id)->count();
        $cekpromo = ProdukPromo::where('produk_id', $request->produk_id)->count();
        if ($cekeventdetail > 0) {
            return back()->with('error', 'Produk sudah masuk dalam event lain');
        } else {
            if ($cekpromo > 0) {
                return back()->with('error', 'Produk sudah memiliki promo');
            } else {
                $itemuser = $request->user();
                $input = $request->all();
                $input['user_id'] = $itemuser->id;
                $itemeventdetail = EventDetail::create($input);
                return redirect()->route('eventdetail.index')->with('success', 'Poduk berhasil ditambahkan ke dalam event');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventDetail  $eventDetail
     * @return \Illuminate\Http\Response
     */
    public function show(EventDetail $eventDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventDetail  $eventDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(EventDetail $eventDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventDetail  $eventDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventDetail $eventDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventDetail  $eventDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemeventdetail = EventDetail::findOrFail($id);
        if ($itemeventdetail->delete()) {
            return back()->with('success', 'Produk berhasil dihapus dari event');
        } else {
            return back()->with('error', 'Produk gagal dihapus dari event');
        }
    }
}
