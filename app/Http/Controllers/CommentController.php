<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function createComment(Request $request, $blog_id, $slug)
    {
        $request->validate([
            'name' => 'required',
            'comment' => 'required'
        ]);

        Comment::create([
            'name' => $request->name,
            'comment' => $request->comment,
            'blog_id' => $blog_id,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('blog.show', ['blog'=>$slug])->with('message', 'Comment added successfully');
        // return redirect()->back()->with('message', 'Comment added successfully'); This is also correct
    }

    public function deleteComment($comment_id)
    {
        $post = Comment::where('id', $comment_id);
        $post->delete();

        return redirect()->back()->with('message',  'Comment has been deleted successfully');
    }
}
