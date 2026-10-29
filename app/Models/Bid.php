<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = ['project_id','developer_id','harga','durasi','proposal','is_winner'];
    public function project()   { 
        return $this->belongsTo(Project::class); 
    }
    public function developer() { 
        return $this->belongsTo(User::class, 'developer_id'); 
    }
}
