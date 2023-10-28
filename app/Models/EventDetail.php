<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    use HasFactory;
    protected $table = 'event_detail';
    protected $fillable = [
        'event_id',
        'produk_id',
        'harga_awal',
        'harga_akhir',
        'diskon_persen',
        'diskon_nominal',
        'user_id',
    ];

    public function event() {
        return $this->belongsTo('App\Models\Event', 'event_id');
    }

    public function produk() {
        return $this->belongsTo('App\Models\Produk', 'produk_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
