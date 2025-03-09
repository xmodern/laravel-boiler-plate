<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AnnouncementType;
use App\Models\AnnouncementCategory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcements>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_id' => AnnouncementType::inRandomOrder()->first()->id,
            'category_id' => AnnouncementCategory::inRandomOrder()->first()->id,
            'title' => $this->faker->sentence,
            'position' => $this->faker->jobTitle,
            'degree' => $this->faker->word,
            'open_position' => $this->faker->numberBetween(1, 10),
            'start_date' => $this->faker->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d'),
            'end_date' => $this->faker->optional()?->dateTimeBetween('+2 months', '+6 months')?->format('Y-m-d'),
        ];
    }
}
