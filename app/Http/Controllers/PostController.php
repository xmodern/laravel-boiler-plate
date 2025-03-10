<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Transformers\PostTransformer;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $postData = fractal($posts, new PostTransformer())->toArray()['data'];


        return Inertia::render('Post/Index')->with([
          'posts'=>$postData
        ]);
    }

    public function store(Request $request)
    {
        $req = $request->validate([
            'id' => ['nullable', 'exists:users,id'],
            'content' => ['required', 'string'],
        ]);
        $user = Auth::user();
        if (!$user) {
            abort(500);
        }
        Post::create([
            'user_id' => $user->id,
            'content' => $req['content'],
        ]);
        return redirect()->back();
    }

    public function update(Request $request, Post $post)
    {
        $req = $request->validate([
            'id' => ['required', 'exists:posts,id'],
            'content' => ['required', 'string'],
        ]);
        $user = Auth::user();
        if (!$user) {
            abort(500);
        }
        $post->content = $req['content'];
        $post->save();
        return redirect()->back();
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back();
    }


}
