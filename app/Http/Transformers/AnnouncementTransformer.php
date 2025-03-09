<?php

namespace App\Http\Transformers;


use App\Models\Announcement;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Phattarachai\ThaiDate\ThaiDate;

class AnnouncementTransformer extends TransformerAbstract
{
    protected array $availableIncludes = ['documents'];

    public function transform(Announcement $announcement): array
    {
        $data = [
            'id' => $announcement->id,
            'type_id' => $announcement->type_id,
            'type_name' => $announcement->type->name,
            'category_id' => $announcement->category_id,
            'category_name' => $announcement->category->name,
            'title' => $announcement->title,
            'position' => $announcement->position,
            'degree' => $announcement->degree,
            'open_position' => $announcement->open_position,
            'start_date' => $announcement->start_date,
            'end_date' => $announcement->end_date,
            'display_start_date' => Carbon::parse($announcement->start_date)->thaidate('j M Y'),
            'display_end_date' => Carbon::parse($announcement->end_date)->thaidate('j M Y'),

        ];
        return $data;
    }

    public function includeDocuments(Announcement $announcement)
    {
        $documents = $announcement->getMedia(Announcement::MEDIA_COLLECTION_DOCUMENTS);
        return $this->collection($documents, new AnnouncementDocumentTransformer());
    }
}
