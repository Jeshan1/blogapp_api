<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    protected $guarded = [];

    public function categories(){
        return $this->belongsToMany(Category::class,'category_blog');
    }

    public function metadata(){
        return $this->hasOne(MetaData::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
