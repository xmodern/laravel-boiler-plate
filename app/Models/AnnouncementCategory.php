<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $hidden = ['create_at', 'updated_at'];

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'category_id');
    }
}
