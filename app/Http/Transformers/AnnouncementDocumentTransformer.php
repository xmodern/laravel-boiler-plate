<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AnnouncementDocumentTransformer extends TransformerAbstract
{
    public function transform(Media $media): array
    {
        $data = [
            'id' => $media->id,
            'url' => $media->getFullUrl(),
            'name' => $media->file_name
        ];

        return $data;
    }
}
