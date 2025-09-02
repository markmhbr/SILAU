<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    protected $fillable = [
        'user_id', 
        'foto', 
        'alamat', 
        'no_hp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
