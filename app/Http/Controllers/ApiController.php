<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // Сначала сделал этот метод потом только понял что в тз требуется отдельный файл api.php
    // Этот код рабочий удалять его не стал, выполняется по примеру /api?action=getPosts
    // В браузере выглядит красивее)
    public function handle(Request $request)
    {
        $action = $request->query('action');

        switch ($action) {
            case 'getUsers':
                return $this->getUsers();
            case 'getPosts':
                return $this->getPosts();
            case 'getComments':
                return $this->getComments();
            case 'getCommentsCount':
                return $this->getCommentsCount();
            case 'getUser':
                return $this->getUser($request);
            case 'getPost':
                return $this->getPost($request);
            case 'getUserPosts':
                return $this->getUserPosts($request);
            case 'getPostComments':
                return $this->getPostComments($request);
            case 'createUser':
                return $this->createUser($request);
            case 'createPost':
                return $this->createPost($request);
            case 'createComment':
                return $this->createComment($request);
            default:
                return response()->json(['error' => 'Invalid action'], 400);
        }
    }

    // Методы для получения данных
    private function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    private function getPosts()
    {
        $posts = Post::with('user')->get();
        return response()->json($posts);
    }

    private function getComments()
    {
        $comments = Comment::with('user', 'post')->get();
        return response()->json($comments);
    }

    private function getCommentsCount()
    {
        $commentsCount = Comment::select(DB::raw('user_id, COUNT(*) as count'))
            ->groupBy('user_id')
            ->get();
        return response()->json($commentsCount);
    }

    private function getUser(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->query('id'));
        return response()->json($user);
    }

    private function getPost(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:posts,id',
        ]);

        $post = Post::with('user')->find($request->query('id'));
        return response()->json($post);
    }

    private function getUserPosts(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        $posts = Post::where('user_id', $request->query('id'))->get();
        return response()->json($posts);
    }

    private function getPostComments(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:posts,id',
        ]);

        $comments = Comment::where('post_id', $request->query('id'))->get();
        return response()->json($comments);
    }

    // Методы для создания данных
    private function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }

    private function createPost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $post = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => $request->input('user_id'),
        ]);

        return response()->json($post, 201);
    }

    private function createComment(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $comment = Comment::create([
            'content' => $request->input('content'),
            'post_id' => $request->input('post_id'),
            'user_id' => $request->input('user_id'),
        ]);

        return response()->json($comment, 201);
    }
}
