<?php

namespace App\Http\Transformers;


use App\Models\Post;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Phattarachai\ThaiDate\ThaiDate;
use Illuminate\Support\Str;

class PostTransformer extends TransformerAbstract
{
    protected array $availableIncludes = ['image'];

    public function transform(Post $post): array
    {
        $data = [
            'id' => $post->id,
            'content' => Str::words($post->content, 20, '...'),
            'display_created_at' => Carbon::parse($post->created_at)->thaidate('j M Y H:i'),
            'display_updated_at' => Carbon::parse($post->updated_at)->thaidate('j M Y H:i'),
            'user' => $post->user->toArray(),
            'role' => $post->user->role->toArray()
        ];
        return $data;
    }

    public function includeImage(Post $post)
    {
        $image = $post->getMedia(Post::MEDIA_COLLECTION_IMAGE)->first();
        if (!$image) {
            return null;
        }
        return $this->item($image, new ImageTransformer());
    }

}
