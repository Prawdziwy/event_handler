<?php

namespace Database\Factories;

use App\Models\Calendar;
use App\Models\CalendarEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalendarEvent>
 */
class CalendarEventFactory extends Factory
{
    protected $model = CalendarEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'calendar_id' => Calendar::factory(),
            'start_date' => $this->faker->dateTimeBetween('+0 days', '+1 month'), 
            'end_date' => $this->faker->dateTimeBetween('+1 days', '+2 months'),
        ];
    }
}
