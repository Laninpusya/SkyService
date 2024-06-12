@extends('layout')

@section('title', 'Comments')

@section('content')
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1>Comments List</h1>
        <a href="{{ route('comment.create') }}" class="btn btn-primary">Create New Comment</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Content</th>
            <th>Post Title</th>
            <th>User Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ $comment->content }}</td>
                <td>{{ $comment->post->title }}</td>
                <td>{{ $comment->user->name }}</td>
                <td>
                    <a href="{{ route('comment.edit', $comment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
