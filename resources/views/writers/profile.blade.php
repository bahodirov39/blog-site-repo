@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center mx-auto">
            <h4>{{ $user->name }}'s profile</h4>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success mt-3" role="alert">
                {{ session()->get('message') }}
            </div>
        @endif

        @if (session()->has('messageDel'))
            <div class="alert alert-danger mt-3" role="alert">
                {{ session()->get('messageDel') }}
            </div>
        @endif

        <div class="col-md-12 mx-auto">
            <div class="row">

                <div class="col-md-6">
                    <h5>Profile details</h5>
                    <ol class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div>Name: <strong> {{ $user->name }} </strong></div>
                            </div>
                            @if (!isset(Auth::user()->id))
                                <p>Please login to use site</p>
                            @else
                                @if (isset(Auth::user()->id) && Auth::user()->id == $user->id)
                                    That is your profile
                                @else
                                    @if ($countFollow == 1)
                                        <a href="{{ route('delFollow', ['from_user_id'=>Auth::user()->id, 'to_user_id'=>$user->id]) }}" class="text-dark">Unfollow <i class="bi bi-heart"></i></a>
                                    @else
                                        <a href="{{ route('addFollow', ['from_user_id'=>Auth::user()->id, 'to_user_id'=>$user->id]) }}" class="text-danger">Follow <i class="bi bi-heart"></i></a>
                                    @endif
                                @endif
                            @endif
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div>Mail: <strong> {{ $user->email }} </strong></div>
                            </div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div>Registered at: <strong> {{ date('d.m.y H:m',strtotime($user->created_at)) }} </strong></div>
                            </div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div>Number of posts: <strong><span class="badge bg-primary rounded-pill"> {{ $count->post_number }}</span></strong></div>
                            </div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div>Readers of {{ $user->name }}: <strong><span class="badge bg-primary rounded-pill"> {{ $followers->number }}</span></strong></div>
                            </div>
                        </li>

                    </ol>
                </div>

                <div class="col-md-6">
                    <h5>Posts</h5>
                    <div class="list-group">
                        @php
                            $i = 1;
                        @endphp
                        @forelse ($blog as $b)
                            <a href="{{ route('blog.show', ['blog'=>$b->slug]) }}" class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><span class="badge bg-secondary rounded-pill"> {{ $i++ }}</span> {{ $b->title }}</h5>
                                <small>{{ date('d.m.y H:i',strtotime($b->created_at)) }}</small>
                            </div>
                            </a>
                        @empty
                            <p>There is no posts yet</p>
                        @endforelse
                        <div class="mt-2">
                        {{ $blog->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
