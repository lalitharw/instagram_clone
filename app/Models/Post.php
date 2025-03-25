<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // relationships

    // between post and post images
    public function images(){
        return $this->hasMany(PostImage::class,foreignKey: "post_id");
    }
}
