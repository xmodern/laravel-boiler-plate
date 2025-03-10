<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const MEDIA_COLLECTION_IMAGE = 'image';

    protected $fillable = ['user_id', 'content'];

    protected $casts = [
        'content' => 'string',
        'user_id' => 'integer'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_IMAGE)->singleFile();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}


