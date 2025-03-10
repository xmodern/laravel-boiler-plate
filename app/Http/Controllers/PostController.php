<?php

namespace App\Http\Controllers;

use App\Http\Transformers\PostTransformer;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $postData = fractal($posts, new PostTransformer())
            ->includeImage()
            ->toArray()['data'];
        return Inertia::render('Post/Index')->with([
            'posts' => $postData
        ]);
    }

    public function store(Request $request)
    {
        $req = $request->validate([
            'id' => ['nullable', 'exists:users,id'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:10240'],
        ]);
        $user = Auth::user();
        if (!$user) {
            abort(500);
        }
        $newPost = Post::create([
            'user_id' => $user->id,
            'content' => $req['content'],
        ]);
        if (isset($req['image']) && !empty($req['image'])) {
            $newPost->addMedia($req['image'])->toMediaCollection(Post::MEDIA_COLLECTION_IMAGE);
        }
        return redirect()->back();
    }

    public function update(Request $request, Post $post)
    {
        $req = $request->validate([
            'id' => ['required', 'exists:posts,id'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:10240'],
        ]);
        $user = Auth::user();
        if (!$user) {
            abort(500);
        }
        $post->content = $req['content'];
        $post->save();
        if (isset($req['image']) && !empty($req['image'])) {
            $post->addMedia($req['image'])->toMediaCollection(Post::MEDIA_COLLECTION_IMAGE);
        }
        return redirect()->back();
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back();
    }
}
