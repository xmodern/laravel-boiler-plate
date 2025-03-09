<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AnnouncementCategory;

class AnnouncementCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AnnouncementCategory::factory()->create([
            'name' => 'รับสมัครงาน'
        ]);

        AnnouncementCategory::factory()->create([
            'name' => 'รายชื่อผู้มีสิทธิ์สอบข้อเขียน'
        ]);
        AnnouncementCategory::factory()->create([
            'name' => 'รายชื่อผู้มีสิทธิ์สอบสัมภาษณ์'
        ]);

        AnnouncementCategory::factory()->create([
            'name' => 'รายชื่อผู้ที่ผ่านการสอบคัดเลือก'
        ]);
    }
}
