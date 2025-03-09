<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\Dashboard\SaveAnnouncementAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreateOrUpdateAnnouncementRequest;
use App\Models\AnnouncementCategory;
use App\Models\AnnouncementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use App\Models\Announcement;
use App\Http\Transformers\AnnouncementTransformer;

class AnnouncementController extends Controller
{

    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'type_id']);
        $announcements = Announcement::filter($filters)->orderBy('start_date', 'desc')->paginate(30);
        $announcementsData = fractal($announcements, new AnnouncementTransformer())->includeDocuments()->toArray();
        $allTypes = AnnouncementType::all()->toArray();
        $allCategories = AnnouncementCategory::all()->toArray();
        return Inertia::render('Dashboard/Announcement/Index')->with([
            'allTypes' => $allTypes,
            'allCategories' => $allCategories,
            'announcements' => $announcementsData,
        ]);
    }

    public function create()
    {
        $allTypes = AnnouncementType::all()->toArray();
        $allCategories = AnnouncementCategory::all()->toArray();
        return Inertia::render('Dashboard/Announcement/Create')->with([
            'allTypes' => $allTypes,
            'allCategories' => $allCategories,
            'announcement' => new Announcement(),
        ]);
    }

    public function store(CreateOrUpdateAnnouncementRequest $request, SaveAnnouncementAction $saveAnnouncementAction)
    {
        $announcement = $saveAnnouncementAction->execute(new Announcement(), $request->validated());
        return redirect()
            ->route("dashboard.announcements.show", $announcement)
            ->with("success", "Announcement updated.");
    }

    public function show(Announcement $announcement)
    {
        $allTypes = AnnouncementType::all()->toArray();
        $allCategories = AnnouncementCategory::all()->toArray();
        $announcementData = fractal($announcement, new AnnouncementTransformer())->includeDocuments()->toArray();
        return Inertia::render('Dashboard/Announcement/Show')->with([
            'allTypes' => $allTypes,
            'allCategories' => $allCategories,
            'announcement' => $announcementData,
        ]);
    }

    public function edit(Announcement $announcement)
    {
        $allTypes = AnnouncementType::all()->toArray();
        $allCategories = AnnouncementCategory::all()->toArray();
        $announcementData = fractal($announcement, new AnnouncementTransformer())->includeDocuments()->toArray();
        return Inertia::render('Dashboard/Announcement/Edit')->with([
            'allTypes' => $allTypes,
            'allCategories' => $allCategories,
            'announcement' => $announcementData,
        ]);
    }

    public function update(
        CreateOrUpdateAnnouncementRequest $request,
        Announcement $announcement,
        SaveAnnouncementAction $saveAnnouncementAction
    ) {
        $saveAnnouncementAction->execute($announcement, $request->validated());

        return redirect()
            ->route("dashboard.announcements.show", $announcement)
            ->with("success", "Announcement updated.");
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        Session::flash('success', 'Announcement deleted.');
    }

}
