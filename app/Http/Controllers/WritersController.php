<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WritersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
        SELECT u.*, COUNT(b.title) AS number
        FROM Users AS u
        LEFT JOIN BLogs AS b ON u.ID = b.user_id
        GROUP BY u.id, b.title
        */

        $data = DB::table('users')
        ->select(array('users.id as uid', 'users.name as uname', DB::raw('COUNT(blogs.id) as post_number')))
        ->leftJoin('blogs', 'users.id', '=', 'blogs.user_id')
        ->groupBy('users.id')
        ->orderBy('post_number', 'desc')
        ->get();

        return view('writers.index', [
            'data' => $data
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
        /*
        $data = DB::table('users')
        ->select(array('users.id as uid', 'users.name as uname', 'blogs.id as bid', 'blogs.title', 'blogs.slug', 'blogs.article', 'blogs.created_at', 'blogs.updated_at', 'blogs.user_id', 'blogs.image_path', DB::raw('COUNT(blogs.id) as post_number')))
        ->where('users.id', '=', $id)
        ->leftJoin('blogs', 'users.id', '=', 'blogs.user_id')
        ->groupBy('users.id', 'blogs.id')
        ->first();
        */

        $count = DB::table('users')
        ->select(array(DB::raw('COUNT(blogs.id) as post_number')))
        ->where('users.id', '=', $id)
        ->leftJoin('blogs', 'users.id', '=', 'blogs.user_id')
        ->groupBy('users.id')
        ->first();

        $user = DB::table('users')
        ->select('*')
        ->where('id', '=', $id)
        ->first();

        $blog = DB::table('blogs')
        ->select('*')
        ->where('user_id', '=', $id)
        ->orderBy('blogs.created_at', 'DESC')
        ->paginate(10);

        // SELECT COUNT(u.id) FROM users u INNER JOIN follows f ON u.id = f.to_user_id WHERE f.to_user_id=2

        $followers = DB::table('users')
        ->select(array(DB::raw('COUNT(users.id) as number')))
        ->where('users.id', '=', $user->id)
        ->join('follows', 'users.id', '=', 'follows.to_user_id')
        ->first();

        if (isset(Auth::user()->id)) {   
            $followRow = Follow::where([['from_user_id', Auth::user()->id], ['to_user_id', $user->id]])->count();
        }else{
            $followRow = '';
        }

        return view('writers.profile', [
            'user' => $user,
            'blog' => $blog,
            'count' => $count,
            'countFollow' => $followRow,
            'followers' => $followers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
