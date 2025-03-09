<?php

namespace App\Http\Controllers;

use App\Http\Transformers\AnnouncementTransformer;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use App\Models\AnnouncementType;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type_id' => ['nullable', 'exists:announcement_types,id'],
            'category_id' => ['nullable', 'exists:announcement_categories,id']
        ]);

        $filters = $request->only(['category_id', 'type_id']);
        $announcements = Announcement::filter($filters)->orderBy('start_date','desc')->paginate(10);
        $announcementData = fractal($announcements, new AnnouncementTransformer())->includeDocuments()->toArray();
        return response()->json($announcementData);
    }

    public function getAllAnnouncementTypes()
    {
        $allAnnouncementTypes = AnnouncementType::all();
        return response()->json($allAnnouncementTypes);
    }

    public function getAllAnnouncementCategories()
    {
        $allAnnouncementCategories = AnnouncementCategory::all();
        return response()->json($allAnnouncementCategories);
    }


}
