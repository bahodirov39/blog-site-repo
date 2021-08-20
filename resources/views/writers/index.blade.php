@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4>Writers list</h4>
        </div>
        <div class="col-md-8 mx-auto">
            @php
                $i = 1;
            @endphp
            @forelse ($data as $user)
                <ol class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">{{ $i++ }}.
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">{{ $user->uname }}</div>
                        <a href="{{ route('writers.show', ['writer'=>$user->uid]) }}">See the profile</a>
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
