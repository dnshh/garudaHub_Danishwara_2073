<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['klien_id','judul','deskripsi','kategori','budget_min','budget_max','batas_lelang','status'];

    public function klien() { 
        return $this->belongsTo(User::class, 'klien_id'); 
    }
    public function bids()   { 
        return $this->hasMany(Bid::class); 
    }
    
    protected $casts = [
        'batas_lelang' => 'date',
    ];

    protected $attributes = [
        'is_winner' => 'boolean',
    ];
}
