<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        $users = User::all();
        return view('post.create',[
            'users' => $users]);
    }

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $post = new Post();
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->user_id = $validatedData['user_id'];
        $post->save();

        return redirect()->route('post.index')->with('success', 'Запис успішно створено');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $users = User::all();
        return view('post.edit',[
            'users' => $users,
            'post' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->user_id = $validatedData['user_id'];
        $post->save();

        return redirect()->route('post.index')->with('success', 'Запис успішно створено');
    }

    public function destroy($id)
    {
        try {
            DB::table('posts')->where('id', $id)->delete();
            return redirect()->route('post.index')->with('success', 'Пост успішно видалено');
        } catch (\Exception $e) {
            return redirect()->route('post.index')->with('error', 'Виникла помилка при видаленні поста');
        }
    }
}

