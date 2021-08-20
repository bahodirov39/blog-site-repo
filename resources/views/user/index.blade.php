@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <h4 class="text-center">Welcome, {{ Auth::user()->name }}</h4>
            
            <div class="text-center">
                <a href="{{ route('blog.create') }}" class="btn btn-success"> <i class="bi bi-plus"></i> Create new</a>
                <a href="{{ route('indexBookmark') }}" class="btn btn-warning"><i class="bi bi-bookmark-fill"></i> Bookmark list</a>
                <a href="{{ route('indexLikes') }}" class="btn btn-danger"><i class="bi bi-hand-thumbs-up"></i> Liked posts</a>
                <a href="{{ route('userpage.edit', ['userpage'=>Auth::user()->id]) }}" class="btn btn-primary"><i class="bi bi-person-bounding-box"></i> Edit profile</a>
                <a href="{{ route('followIndex') }}" class="btn btn-dark"><i class="bi bi-heart"></i> Follows</a>
                <a href="{{ route('followers') }}" class="btn btn-dark"><i class="bi bi-link-45deg"></i> Followers</a>
                <a href="{{ route('feed') }}" class="btn btn-primary"><i class="bi bi-file-post-fill"></i> Feed</a>
            </div>

            @if (session()->has('addmessage'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session()->get('addmessage') }}
                </div>
            @endif

            @if (session()->has('edited'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session()->get('edited') }}
                </div>
            @endif

            @if (session()->has('message'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session()->get('message') }}
                </div>
            @endif

            <div class="row mt-4">
                <h5>My posts</h5>
                @forelse ($posts as $post)
                    <div class="col-md-4 mt-2">
                        <div class="card shadow" style="width: 18rem;">
                            <img src="{{ asset('images/'.$post->image_path) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text"> {{ $post->article }} </p>
                                <a href="{{ route('blog.show', ['blog'=>$post->slug]) }}" class="btn btn-primary">Go to read</a>
                            </div>
                        </div>
                    </div>
                @empty
                    
                    <div class="alert alert-warning mt-3" role="alert">
                        No posts
                    </div>
                    
                @endforelse
                </div>
        </div>
    </div>
</div>
@endsection
