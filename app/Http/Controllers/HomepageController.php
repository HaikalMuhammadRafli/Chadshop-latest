<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Slideshow;
use App\Models\ProdukPromo;
use App\Models\Wishlist;
use App\Models\Ulasan;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\About;
use App\Models\Kontak;
use Auth;

class HomepageController extends Controller
{
    public function index() {
        $itemproduk = Produk::orderBy('created_at', 'desc')->limit(10)->get();
        $itempromo = ProdukPromo::orderBy('created_at', 'desc')->limit(10)->get();
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->limit(6)->get();
        $itemslide = Slideshow::get();
        $itemevent = Event::where('status', 'aktif')->get();

        $data = array('title' => 'Homepage',
            'itemproduk' => $itemproduk,
            'itempromo' => $itempromo,
            'itemkategori' => $itemkategori,
            'itemslide' => $itemslide,
            'itemevent' => $itemevent,
        );
        return view('homepage.index', $data);
    }

    public function about() {
        $about = About::first();

        $data = array(
            'title' => 'Tentang Kami',
            'about' => $about);
        return view('homepage.about', $data);
    }

    public function kontak() {
        $itemkontak = Kontak::get();

        $data = array('title' => 'Kontak Kami',
                    'itemkontak' => $itemkontak);
        return view('homepage.kontak', $data);
    }

    public function kategori() {
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->limit(6)->get();
        $itemproduk = Produk::orderBy('created_at', 'desc')->limit(10)->get();
        $data = array('title' => 'Kategori Produk',
                    'itemkategori' => $itemkategori,
                    'itemproduk' => $itemproduk);
        return view('homepage.kategori', $data);
    }
    
    public function kategoribyslug(Request $request, $slug) {
        $itemproduk = Produk::orderBy('nama_produk', 'desc')
                            ->where('status', 'publish')
                            ->whereHas('kategori', function($q) use ($slug) {
                                $q->where('slug_kategori', $slug);
                            })
                            ->paginate(18);
        $listkategori = Kategori::orderBy('nama_kategori', 'asc')
                                ->where('status', 'publish')
                                ->get();
        $itemkategori = Kategori::where('slug_kategori', $slug)
                                ->where('status', 'publish')
                                ->first();
        if ($itemkategori) {
            $data = array('title' => $itemkategori->nama_kategori,
                        'itemproduk' => $itemproduk,
                        'listkategori' => $listkategori,
                        'itemkategori' => $itemkategori);
            return view('homepage.produk', $data)->with('no', ($request->input('page') - 1) * 18);
        } else {
            return abort('404');
        }
    }
    public function produk(Request $request) {
        $cari = $request->query('key');
        $itemproduk = Produk::orderBy('nama_produk', 'desc')
                            ->where('status', 'publish')
                            ->paginate(18);
        $produkcari = Produk::orderBy('nama_produk', 'desc')
                            ->where('status', 'publish')
                            ->where('nama_produk', 'LIKE', '%' . $cari . '%')
                            ->paginate(18);
        $listkategori = Kategori::orderBy('nama_kategori', 'asc')
                                ->where('status', 'publish')
                                ->get();
        $data = array('title' => 'Produk',
                    'itemproduk' => $itemproduk,
                    'itemproduk' => $produkcari,
                    'listkategori' => $listkategori);
        return view('homepage.produk', $data)->with('no', ($request->input('page') - 1) * 18);
    }

    public function produkdetail(Request $request, $slug) {   
        $itemuser = $request->user();
        $itemproduk = Produk::where('slug_produk', $slug)
                            ->where('status', 'publish')
                            ->first();
        $itemulasan = Ulasan::with('reply')
                            ->orderBy('created_at', 'desc')
                            ->where('produk_id', $itemproduk->id)
                            ->paginate(10);
        $ratingsum = Ulasan::where('produk_id', $itemproduk->id)->sum('rating');
        if ($itemulasan->count() > 0) {
            $ratingvalue = $ratingsum / $itemulasan->count();
        } else {
            $ratingvalue = 0;
        }

        if ($itemproduk) {
            if (Auth::user()) {//cek kalo user login
                $itemuser = Auth::user();
                $itemwishlist = Wishlist::where('produk_id', $itemproduk->id)
                                        ->where('user_id', $itemuser->id)
                                        ->first();
                $data = array('title' => $itemproduk->nama_produk,
                        'itemproduk' => $itemproduk,
                        'itemwishlist' => $itemwishlist,
                        'itemulasan' => $itemulasan,
                        'ratingvalue' => $ratingvalue,
                        'itemuser' => $itemuser);
            } else {
                $data = array('title' => $itemproduk->nama_produk,
                            'itemproduk' => $itemproduk,
                            'itemulasan' => $itemulasan,
                            'ratingvalue' => $ratingvalue,
                            'itemuser' => $itemuser);
            }
            return view('homepage.produkdetail', $data);
        } else {
            // kalo produk ga ada, jadinya tampil halaman tidak ditemukan (error 404)
            return abort('404');
        }
    }

    public function event(Request $request, $slug) {
        $itemeventdetail = EventDetail::orderBy('created_at', 'desc')
                            ->whereHas('event', function($q) use ($slug) {
                                $q->where('slug_event', $slug);
                            })
                            ->paginate(10);
        $itemevent = Event::where('slug_event', $slug)->first();

        if ($itemevent) {
            $data = array('title' => $itemevent->nama_event,
                        'itemeventdetail' => $itemeventdetail,
                        'itemevent' => $itemevent);
            return view('homepage.event', $data)->with('no', ($request->input('page') - 1) * 18);
        } else {
            return abort('404');
        }
    }
}

