<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Blog extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'blogs';

    protected $fillable = ['title', 'article', 'image_path', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookmark()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function commmentlike()
    {
        return $this->hasMany(CommentLike::class);
    }

    public function like()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
