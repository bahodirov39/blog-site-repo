<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    public function index()
    {
        /*
        SELECT u.*, b.*, COUNT(b.id) AS posts FROM users u 
        INNER JOIN follows f ON u.id=f.to_user_id 
        INNER JOIN blogs b ON u.id=b.user_id 
        WHERE f.to_user_id=1 
        GROUP BY u.id
        */

        $data = DB::table('users')
        ->where('from_user_id', Auth::user()->id)
        ->select(array('users.*', 'users.id as uid', 'blogs.*', DB::raw('COUNT(blogs.id) as post_number')))
        ->join('follows', 'users.id', '=', 'follows.to_user_id')
        ->join('blogs', 'users.id', '=', 'blogs.user_id')
        ->groupBy('users.id')
        ->orderBy('post_number', 'desc')
        ->get();
        
        return view('user.follows', [
            'data' => $data
        ]);
    }

    public function followers()
    {
        /*
        SELECT u.*, b.*, COUNT(b.id) AS posts FROM users u 
        INNER JOIN follows f ON u.id=f.to_user_id 
        INNER JOIN blogs b ON u.id=b.user_id 
        WHERE f.to_user_id=1 
        GROUP BY u.id
        */

        $data = DB::table('users')
        ->where('to_user_id', Auth::user()->id)
        ->select(array('users.*', 'users.id as uid', 'blogs.*', DB::raw('COUNT(blogs.id) as post_number')))
        ->join('follows', 'users.id', '=', 'follows.from_user_id')
        ->join('blogs', 'users.id', '=', 'blogs.user_id')
        ->groupBy('users.id')
        ->orderBy('post_number', 'desc')
        ->get();
        
        return view('user.followers', [
            'data' => $data
        ]);
    }

    public function addFollow($from_user_id, $to_user_id)
    {
        Follow::create([
            'from_user_id' => $from_user_id,
            'to_user_id' => $to_user_id
        ]);

        return redirect()->back()->with('message', 'You have followed this writer');
    }

    public function delFollow($from_user_id, $to_user_id)
    {
        $post = Follow::where([['from_user_id', $from_user_id], ['to_user_id', $to_user_id]]);
        $post->delete();

        return redirect()->back()->with('messageDel',  'You have unfollowed this writer');
    }
}