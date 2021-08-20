<?php

namespace App\Http\Controllers;

use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeController extends Controller
{
    public function addCommentLike($blog_id, $comment_id)
    {
        CommentLike::create([
            'user_id' => Auth::user()->id,
            'blog_id' => $blog_id,
            'comment_id' => $comment_id
        ]);

        return redirect()->back()->with('messageLike', 'You liked comment');
    }
}