<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     protected $fillable = ['client_id','judul','deskripsi','kategori','budget_min','budget_max','batas_lelang','status'];

    public function client() { 
        return $this->belongsTo(User::class, 'client_id'); 
    }
    public function bids()   { 
        return $this->hasMany(Bid::class); 
    }
}
