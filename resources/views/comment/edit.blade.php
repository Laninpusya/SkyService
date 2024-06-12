@extends('layout')

@section('title', 'Edit Comment')

@section('content')
    <div class="container mt-4">
        <h1>Edit Comment</h1>
        <form action="{{ route('comment.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" required>{{ $comment->content }}</textarea>
            </div>

            <div class="form-group">
                <label for="post_id">Post:</label>
                <select class="form-control" id="post_id" name="post_id">
                    @foreach($posts as $post)
                        <option value="{{ $post->id }}" {{ $post->id == $comment->post_id ? 'selected' : '' }}>
                            {{ $post->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="user_id">User:</label>
                <select class="form-control" id="user_id" name="user_id">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $comment->user_id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Comment</button>
        </form>
    </div>
@endsection
