@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h4 class="text-center">Create new post</h4>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('blog.update', ['blog'=>$post->slug]) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="mb-3">
                  <label for="title" class="form-label">Title</label>
                  <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" placeholder="Title">
                </div>
                <div class="mb-3">
                  <label for="article" class="form-label">Article</label>
                  <textarea type="text" class="form-control" id="article" name="article" placeholder="Article" rows="3">{{ $post->article }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>
</div>
@endsection
