@extends('layout')

@section('title', 'Create Comment')

@section('content')
    <div class="container mt-4">
        <h1>Create Comment</h1>
        <form action="{{ route('comment.save') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" required></textarea>
            </div>

            <div class="form-group">
                <label for="post_id">Post:</label>
                <select class="form-control" id="post_id" name="post_id">
                    @foreach($posts as $post)
                        <option value="{{ $post->id }}">{{ $post->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="user_id">User:</label>
                <select class="form-control" id="user_id" name="user_id">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Comment</button>
        </form>
    </div>
@endsection
