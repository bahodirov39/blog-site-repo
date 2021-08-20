@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (isset(Auth::user()->id) && Auth::user()->id == $post->user->id)
            <div class="row">
                <div class="col d-flex">
                    <a href="{{ route('blog.edit', ['blog'=>$post->slug]) }}" class="btn btn-primary btn-sm"> <i class="bi bi-pen"></i> Edit</a>
                    <form action="{{ route('blog.destroy', ['blog' => $post->slug ]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm ml-2"> <i class="bi bi-trash"></i> Delete</button>
                    </form>
                </div>
            </div>
            @endif
            <h4 class="text-center">{{ $post->title }}</h4>
            <img src="{{ asset('images/'.$post->image_path) }}" class="img-fluid rounded my-2" alt="Post_image">
            <p>{{ $post->article }}</p>
            
            <br>
            Created by <a href="{{ route('writers.show', ['writer'=>$post->user->id]) }}"> <small class="badge bg-info"> {{ $post->user->name }} </a> </small>
            <br>
            <br>
            @if (session()->has('messageAddBookmark'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session()->get('messageAddBookmark') }}
                </div>
            @endif

            @if (session()->has('messageDelBookmark'))
                <div class="alert alert-danger mt-3" role="alert">
                    {{ session()->get('messageDelBookmark') }}
                </div>
            @endif

            @if (session()->has('messageLike'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session()->get('messageLike') }}
                </div>
            @endif

            @if (session()->has('messageLikedel'))
                <div class="alert alert-danger mt-3" role="alert">
                    {{ session()->get('messageLikedel') }}
                </div>
            @endif

            @if (isset(Auth::user()->id))
                @if ($bookmarksCount == 0)
                    <a href="{{ route('addBookmark', ['blog_id'=>$post->id]) }}" class="btn btn-warning btn-sm text-white"><i class="bi bi-bookmark"></i> Bookmark</a>
                @else
                    <a href="{{ route('deleteBookmark', ['blog_id'=>$post->id]) }}" class="btn btn-secondary btn-sm text-white"><i class="bi bi-bookmark"></i> Delete bookmark</a>
                @endif

                
                @if ($likesCount == 0)
                <a href="{{ route('addLike', ['blog_id'=>$post->id]) }}" class="btn btn-danger btn-sm"><i class="bi bi-hand-thumbs-up"></i> Like </a>
                @else
                <a href="{{ route('deleteLike', ['blog_id'=>$post->id]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-hand-thumbs-down"></i> Dislike </a>
                @endif
            @else
                <a href="/login">Please, login to get all permissions</a>
            @endif
            
            <hr>
            

            <h4>Comment section</h4>
            @if (session()->has('message'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if (isset(Auth::user()->id))
            <form method="POST" action="{{ route('createComment', ['blog_id'=>$post->id, 'slug'=>$post->slug]) }}">
                @csrf
                <div class="mb-3">
                  <label for="title" class="form-label">Name</label>
                  <input type="text" class="form-control" id="title" name="name" value="{{ Auth::user()->name }}" placeholder="Name">
                </div>
                <div class="mb-3">
                  <label for="article" class="form-label">Comment</label>
                  <textarea type="text" class="form-control" id="article" name="comment" placeholder="Your comment..." rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            @else
                <div class="alert alert-alert mt-3" role="alert">
                    You have to login to comment
                </div>
            @endif
            <br>
            <br>

            @forelse ($post->comment as $co)
            <div class="p-2 m-2 bg-white border rounded">
                <h4>{{ $co->name }}</h4>
                <p>{{ $co->comment }}</p>
                <hr>
                <small>Created at: {{ $co->created_at }}</small> 
                @if (Auth::user()->id == $co->user_id)
                | 
                    <a href="{{ route('deleteComment', ['comment_id' => $co->id ]) }}">Delete</a>
                @endif
                
            </div>
            @empty
                <div class="alert alert-primary mt-3" role="alert">
                    There is no comment
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection
