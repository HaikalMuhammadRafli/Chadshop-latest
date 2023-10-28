<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = [
        'kategori_id',
        'user_id',
        'kode_produk',
        'nama_produk',
        'slug_produk',
        'deskripsi_produk',
        'foto',
        'qty',
        'satuan',
        'harga',
        'rating',
        'status',
    ];
    public function kategori() {
        return $this->belongsTo('App\Models\Kategori', 'kategori_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function images() {
        return $this->hasMany('App\Models\ProdukImage', 'produk_id');
    }

    public function promo() {
        return $this->hasOne('App\Models\ProdukPromo', 'produk_id');
    }

    public function ulasan() {
        return $this->hasMany('App\Models\Ulasan', 'produk_id');
    }

    public function eventdetail() {
        return $this->hasOne('App\Models\EventDetail', 'produk_id');
    }

    public function detail() {
        return $this->hasMany('App\Models\CartDetail', 'produk_id');
    }

    public function wishlist() {
        return $this->hasMany('App\Models\Wishlist', 'produk_id');
    }
}
