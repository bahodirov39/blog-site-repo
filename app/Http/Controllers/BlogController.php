<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Bookmark;
use App\Models\CommentLike;
use App\Models\Like;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth', ['except'=>['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Blog::all()->sortByDesc('id');
        
        return view('blog.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'article' => 'required',
            'image' => 'required|mimes:png,jpg, jpeg'
        ]);

        $slug = SlugService::createSlug(Blog::class, 'slug', $request->title);

        $newImageName = uniqid() . '-' . $request->title . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $newImageName); 

        Blog::create([
            'title' => $request->title,
            'article' => $request->article,
            'image_path' => $newImageName,
            'user_id' => Auth::user()->id,
            'slug' => $slug
        ]);

        return redirect()->route('userpage.index')->with('addmessage',  'Post has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Blog::where('slug', $slug)->first();

        if (isset(Auth::user()->id)) {   
            $bookmarksCount = Bookmark::where([['user_id', Auth::user()->id], ['blog_id', $post->id]])->count();
            $likesCount = Like::where([['user_id', Auth::user()->id], ['blog_id', $post->id]])->count();
            $commentLikeRow = CommentLike::where([['user_id', Auth::user()->id], ['blog_id', $post->id]])->count();
            $commentLike = CommentLike::where([['user_id', Auth::user()->id], ['blog_id', $post->id]])->get();
        }else{
            $bookmarksCount = '';
            $likesCount = '';
            $commentLikeRow = '';
            $commentLike = [];
        }

        return view('blog.show', [
            'post' => $post,
            'bookmarksCount' => $bookmarksCount,
            'likesCount' => $likesCount,
            'commentLikeRow' => $commentLikeRow,
            'commentLike' => $commentLike
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Blog::where('slug', $slug)->first();
        return view('blog.update', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required',
            'article' => 'required'
        ]);

        $new_slug = SlugService::createSlug(Blog::class, 'slug', $request->title);

        Blog::where('slug', $slug)->update([
            'title' => $request->title,
            'article' => $request->article,
            'user_id' => Auth::user()->id,
            'slug' => $new_slug
        ]);

        return redirect()->route('blog.index')->with('message',  'Post has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = Blog::where('slug', $slug);
        $post->delete();

        return redirect()->route('userpage.index')->with('message',  'Post has been deleted successfully');
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);

        $search = $request->input('search');

        // Search in the title and body columns from the posts table
        $posts = Blog::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('article', 'LIKE', "%{$search}%")
            ->get();

        // Return the search view with the resluts compacted
        return view('search', compact('posts'));
    }
}
