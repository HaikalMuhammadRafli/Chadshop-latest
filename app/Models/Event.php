<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'event';
    protected $fillable = [
        'kode_event',
        'nama_event',
        'slug_event',
        'banner',
        'status',
        'start_datetime',
        'end_datetime',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function eventdetail() {
        return $this->hasMany('App\Models\EventDetail', 'event_id');
    }
}
