<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Announcement extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const MEDIA_COLLECTION_DOCUMENTS = 'documents';

    protected $fillable = [
        'type_id',
        'category_id',
        'title',
        'position',
        'degree',
        'open_position',
        'start_date',
        'end_date',
    ];
    protected $casts = [
        'create_at' => 'date',
        'updated_at' => 'date',
    ];

    public function type()
    {
        return $this->belongsTo(AnnouncementType::class, 'type_id');
    }

    public function category()
    {
        return $this->belongsTo(AnnouncementCategory::class, 'category_id');
    }


    public function scopeFilter(Builder $query, array $filters): void
    {
        if (isset($filters['category_id']) && $filters['category_id'] != null) {
            $query->where('category_id', $filters['category_id']);
        }
        if (isset($filters['type_id']) && $filters['type_id'] != null) {
            $query->where('type_id', $filters['type_id']);
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_DOCUMENTS);
    }


}
