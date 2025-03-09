<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcement::factory()->count(100)->create();
        $newAnnouncements = Announcement::all();
        foreach ($newAnnouncements as $announcement) {
            $announcement->addMedia(storage_path('seed/sample.pdf'))->preservingOriginal()
                ->toMediaCollection(Announcement::MEDIA_COLLECTION_DOCUMENTS);
        }
    }
}
