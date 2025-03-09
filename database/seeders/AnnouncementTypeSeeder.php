<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnnouncementType;

class AnnouncementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AnnouncementType::factory()->create([
            'name' => 'สายวิชาการ'
        ]);

        AnnouncementType::factory()->create([
            'name' => 'สายสนับสนุน'
        ]);
    }
}
