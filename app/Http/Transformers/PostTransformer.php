<?php

namespace App\Http\Transformers;


use App\Models\Post;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Phattarachai\ThaiDate\ThaiDate;

class PostTransformer extends TransformerAbstract
{
    public function transform(Post $post): array
    {
        $data = [
            'id' => $post->id,
            'content' => $post->content,
            'display_created_at' => Carbon::parse($post->created_at)->thaidate('j M y | H:m'),
            'display_updated_at' => Carbon::parse($post->updated_at)->thaidate('j M y'),
            'user' => $post->user->toArray(),
            'role' => $post->user->role->toArray()
        ];
        return $data;
    }
}
