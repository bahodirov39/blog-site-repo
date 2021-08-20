@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (!isset(Auth::user()->id))
                <h4 class="text-center">Welcome to blog site. Please <a href="/login">login</a> or <a href="/register">register</a> to use site with full permissions.</h4>
            @endif
            <h3 class="text-center bg-white rounded border p-3">This is a blog site where you can search for amazing posts</h3>
            <h5>There are several features so that you can:</h5>
            <ul>
                <li>- create post</li>
                <li>- add posts to your Bookmark list</li>
                <li>- like posts</li>
                <li>- see other writers' profile</li>
                <li>- follow/unfollow other writers</li>
                <li>- see their post as soon as possible whenever they post</li>
                <li>- edit profile/posts</li>
                <li>- add your comment to any posts</li>
                <li>- search posts</li>
            </ul>
        </div>
    </div>
</div>
@endsection
