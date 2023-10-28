<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'reply';
    protected $fillable = [
        'ulasan_id',
        'user_id',
        'isi',
    ];

    public function ulasan() {
        return $this->belongsTo('App\Models\Ulasan', 'ulasan_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
