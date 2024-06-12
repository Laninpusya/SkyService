<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$action = $request->query('action');

switch ($action) {
    case 'getUsers':
        echo response()->json(User::all())->getContent();
        break;

    case 'getUser':
        $id = $request->query('id');
        echo response()->json(User::find($id))->getContent();
        break;

    case 'getPosts':
        echo response()->json(Post::all())->getContent();
        break;

    case 'getPost':
        $id = $request->query('id');
        echo response()->json(Post::find($id))->getContent();
        break;

    case 'getComments':
        echo response()->json(Comment::all())->getContent();
        break;

    case 'getCommentsCount':
        echo response()->json(Comment::selectRaw('user_id, COUNT(*) as count')->groupBy('user_id')->get())->getContent();
        break;

    case 'getUserPosts':
        $id = $request->query('id');
        echo response()->json(Post::where('user_id', $id)->get())->getContent();
        break;

    case 'getPostComments':
        $id = $request->query('id');
        echo response()->json(Comment::where('post_id', $id)->get())->getContent();
        break;

    case 'createUser':
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        echo response()->json($user, 201)->getContent();
        break;

    case 'createPost':
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $post = Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'user_id' => $validatedData['user_id'],
        ]);

        echo response()->json($post, 201)->getContent();
        break;

    case 'createComment':
        $validatedData = $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        $comment = Comment::create([
            'content' => $validatedData['content'],
            'user_id' => $validatedData['user_id'],
            'post_id' => $validatedData['post_id'],
        ]);

        echo response()->json($comment, 201)->getContent();
        break;

    default:
        echo response()->json(['error' => 'Invalid action'], 400)->getContent();
        break;
}

$response->send();
$kernel->terminate($request, $response);
