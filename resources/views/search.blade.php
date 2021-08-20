@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h4 class="text-center">Search results</h4>

            <div class="row mt-4">
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
                        Results not found
                    </div>
                </div>

            @endforelse
        </div>
    </div>
</div>
@endsection
