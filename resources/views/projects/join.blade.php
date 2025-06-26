@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('projects.join.submit') }}">
        @csrf
        <input type="text" name="invite_code" placeholder="Enter Invite Code" required>
        <button type="submit">Join Team</button>
    </form>
</div>
@endsection
