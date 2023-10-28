<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Produk;
use App\Models\Reply;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return abort('404');
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
        $this->validate($request, [
            'produk_id' => 'required',
            'rating' => 'required',
            'isi_ulasan' => 'required',
        ]);
        $itemuser = $request->user();
        $input = $request->all();
        $input['user_id'] = $itemuser->id;
        $itemulasan = Ulasan::create($input);

        if ($itemulasan) {
            $ratingsum = Ulasan::where('produk_id', $request->produk_id)->sum('rating');
            if ($itemulasan->count() > 0) {
                $ratingvalue = $ratingsum / $itemulasan->count();
            } else {
                $ratingvalue = 0;
            }
            $itemproduk = Produk::where('id', $request->produk_id)
                                ->update(['rating' => $ratingvalue]);

            return back()->with('success', 'Berhasil memberi ulasan!');
        } else {
            return back()->with('error', 'Gagal memberi ulasan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ulasan  $ulasan
     * @return \Illuminate\Http\Response
     */
    public function show(Ulasan $ulasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ulasan  $ulasan
     * @return \Illuminate\Http\Response
     */
    public function edit(Ulasan $ulasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ulasan  $ulasan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ulasan $ulasan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ulasan  $ulasan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->validate($request, [
            'produk_id' => 'required',
        ]);

        $itemulasan = Ulasan::findOrFail($id);
        $itemreply = Reply::where('ulasan_id', $itemulasan->id);
        $countreply = $itemreply->count();
        if ($countreply > 0) {
            if ($itemreply->delete()) {
                if ($itemulasan->delete()) {
                    $ratingsum = Ulasan::where('produk_id', $request->produk_id)->sum('rating');
                    if ($itemulasan->count() > 0) {
                        $ratingvalue = $ratingsum / $itemulasan->count();
                    } else {
                        $ratingvalue = 0;
                    }
                    $itemproduk = Produk::where('id', $request->produk_id)
                                        ->update(['rating' => $ratingvalue]);
                    return back()->with('success', 'Ulasan berhasil dihapus');
                } else {
                    return back()->with('error', 'Ulasan gagal dihapus');
                }
            } else {
                return back()->with('error', 'Ulasan gagal dihapus (reply)');
            }
        } else {
            if ($itemulasan->delete()) {
                $ratingsum = Ulasan::where('produk_id', $request->produk_id)->sum('rating');
                    if ($itemulasan->count() > 0) {
                        $ratingvalue = $ratingsum / $itemulasan->count();
                    } else {
                        $ratingvalue = 0;
                    }
                    $itemproduk = Produk::where('id', $request->produk_id)
                                        ->update(['rating' => $ratingvalue]);
                                        
                return back()->with('success', 'Ulasan berhasil dihapus');
            } else {
                return back()->with('error', 'Ulasan gagal dihapus');
            }
        }
    }

    public function beri_ulasan(Request $request, $slug) {
        $itemuser = $request->User();
        $itemproduk = Produk::where('slug_produk', $slug)
                            ->where('status', 'publish')
                            ->first();
        $itemulasan = Ulasan::with('reply')
                            ->orderBy('created_at', 'desc')
                            ->where('produk_id', $itemproduk->id)
                            ->paginate(10);
        $cekulasan = Ulasan::where('produk_id', $itemproduk->id)
                            ->where('user_id', $itemuser->id)
                            ->first();
        $data = array('title' => 'Beri Ulasan',
                    'itemuser' => $itemuser,
                    'itemproduk' => $itemproduk,
                    'itemulasan' => $itemulasan,
                    'cekulasan' => $cekulasan);
        return view('ulasan.create', $data);
    }
}
