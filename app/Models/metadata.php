<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class metadata extends Model
{
    protected $guarded = [];

    public function blog(){
        return $this->belongsTo(Blog::class);
    }
}
