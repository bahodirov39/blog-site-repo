@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-dark text-center"><i class="bi bi-link-45deg text-dark"></i><br>
                Followers
            </h1>
            <a href="{{ route('userpage.index') }}" class="btn btn-success"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="col-md-8 mx-auto mt-2">
            @php
                $i = 1;
            @endphp
            @forelse ($data as $user)
                <ol class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">{{ $i++ }}.
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">{{ $user->name }}</div>
                        <a href="{{ route('writers.show', ['writer'=>$user->id]) }}">See the profile</a>
                    </div>
                    <span class="badge bg-primary rounded-pill">Posts: {{ $user->post_number }}</span>
                    </li>
                </ol>
            @empty
            <p>There is no writers yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
