<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'bookmarks';

    protected $fillable = ['user_id', 'blog_id'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
