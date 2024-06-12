<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['post', 'user'])->get();
        return view('comment.index', compact('comments'));
    }

    public function create()
    {
        $posts = Post::all();
        $users = User::all();
        return view('comment.create', compact('posts', 'users'));
    }

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        Comment::create([
            'content' => $validatedData['content'],
            'post_id' => $validatedData['post_id'],
            'user_id' => $validatedData['user_id'],
        ]);

        return redirect()->route('comment.index')->with('success', 'Comment created successfully.');
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        $posts = Post::all();
        $users = User::all();
        return view('comment.edit', compact('comment', 'posts', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->content = $validatedData['content'];
        $comment->post_id = $validatedData['post_id'];
        $comment->user_id = $validatedData['user_id'];
        $comment->save();

        return redirect()->route('comment.index')->with('success', 'Comment updated successfully.');
    }
    public function destroy($id)
    {
        try {
            DB::table('comments')->where('id', $id)->delete();
            return redirect()->route('comment.index')->with('success', 'Коментар успішно видалено');
        } catch (\Exception $e) {
            return redirect()->route('comment.index')->with('error', 'Виникла помилка при видаленні коментаря');
        }
    }
}
