<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookmarkController extends Controller
{
    public function index()
    {
        $posts = DB::table('blogs')
        ->select('blogs.id','blogs.title','blogs.slug', 'blogs.image_path', 'blogs.article')
        ->join('bookmarks','bookmarks.blog_id','=','blogs.id')
        ->where('bookmarks.user_id', Auth::user()->id)
        ->get();
        
        return view('user.bookmark', [
            'posts' => $posts
        ]);
    }

    public function addBookmark($blog_id)
    {
        Bookmark::create([
            'user_id' => Auth::user()->id,
            'blog_id' => $blog_id
        ]);

        return redirect()->back()->with('messageAddBookmark', 'Added successfully to your Bookmark list');
    }

    public function deleteBookmark($blog_id)
    {
        $post = Bookmark::where('blog_id', $blog_id);
        $post->delete();

        return redirect()->back()->with('messageDelBookmark',  'Bookmark has been deleted successfully');
    }
}
