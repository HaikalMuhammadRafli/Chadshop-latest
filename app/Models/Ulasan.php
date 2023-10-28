<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;
    protected $table = 'ulasan';
    protected $fillable = [
        'produk_id',
        'user_id',
        'rating',
        'isi_ulasan',
        'foto',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function produk() {
        return $this->belongsTo('App\Models\Produk', 'produk_id');
    }

    public function images() {
        return $this->hasMany('App\Models\ProdukImage', 'produk_id');
    }

    public function reply() {
        return $this->hasMany('App\Models\Reply', 'ulasan_id');
    }
}
