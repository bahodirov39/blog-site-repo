@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="text-warning text-center"><i class="bi bi-bookmark text-warning"></i><br>
                Bookmark list
            </h1>
            <a href="{{ route('userpage.index') }}" class="btn btn-success"><i class="bi bi-arrow-left"></i> Back</a>
            <div class="row mt-4">
            @forelse ($posts as $post)
                    <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('images/'.$post->image_path) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text"> {{ $post->article }} </p>
                            <a href="{{ route('blog.show', ['blog'=>$post->slug]) }}" class="btn btn-primary">Go to read</a>
                            </div>
                        </div>
                    </div>
                @empty
            </div>
                    
            <div class="alert alert-warning mt-3" role="alert">
                No posts
            </div>

            @endforelse
        </div>
    </div>
</div>
@endsection
