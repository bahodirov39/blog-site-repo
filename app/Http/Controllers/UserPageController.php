<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserPageController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Blog::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('user.index', [
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        return view('user.update', [
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('userpage.index')->with('edited', 'Profile has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function feed()
    {
        /*
        * 
        * SELECT * FROM users u 
        * INNER JOIN blogs b ON u.id = b.user_id 
        * INNER JOIN follows f ON f.from_user_id = u.id 
        * WHERE f.to_user_id = 2
        */
        
        /*
        $data = DB::table('users')
        ->select(array('users.*', 'blogs.*', 'blogs.id as bid'))
        ->join('blogs', 'users.id', '=', 'blogs.user_id')
        ->join('follows', 'follows.from_user_id', '=', 'users.id')
        ->paginate(9);
        */

        $data = DB::table('users')
        ->select(array('users.*', 'blogs.*', 'blogs.id as bid'))
        ->where('follows.from_user_id', Auth::user()->id)
        ->join('blogs', 'users.id', '=', 'blogs.user_id')
        ->join('follows', 'follows.to_user_id', '=', 'users.id')
        ->orderBy('blogs.created_at', 'DESC')
        ->paginate(9);

        return view('user.feed', [
            'data' => $data
        ]);
    }
}