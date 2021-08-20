<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function index()
    {
        $posts = DB::table('blogs')
        ->select('blogs.id','blogs.title','blogs.slug', 'blogs.image_path', 'blogs.article')
        ->join('likes','likes.blog_id','=','blogs.id')
        ->where('likes.user_id', Auth::user()->id)
        ->get();
        
        return view('user.liked', [
            'posts' => $posts
        ]);
    }

    public function addLike($blog_id)
    {
        Like::create([
            'user_id' => Auth::user()->id,
            'blog_id' => $blog_id
        ]);

        return redirect()->back()->with('messageLike', 'You liked this post');
    }

    public function deleteLike($blog_id)
    {
        $post = Like::where('blog_id', $blog_id);
        $post->delete();

        return redirect()->back()->with('messageLikedel',  'You disliked this post');
    }
}
