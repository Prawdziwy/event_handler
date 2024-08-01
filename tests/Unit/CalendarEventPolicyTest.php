<?php

namespace Tests\Unit;

use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\User;
use App\Policies\CalendarEventPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarEventPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_delete_event_if_member_of_calendar_and_event_belongs_to_calendar()
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create();
        $calendar->members()->attach($user);

        $event = CalendarEvent::factory()->create([
            'calendar_id' => $calendar->id,
        ]);

        $policy = new CalendarEventPolicy();
        $this->assertTrue($policy->verifyCalendar($user, $event, $calendar));
    }

    /** @test */
    public function user_cannot_delete_event_if_not_member_of_calendar()
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create();
        $event = CalendarEvent::factory()->create([
            'calendar_id' => $calendar->id,
        ]);

        $policy = new CalendarEventPolicy();
        $this->assertFalse($policy->verifyCalendar($user, $event, $calendar));
    }

    /** @test */
    public function user_cannot_delete_event_if_event_does_not_belong_to_calendar()
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create();
        $calendar2 = Calendar::factory()->create();
        $calendar2->members()->attach($user);

        $event = CalendarEvent::factory()->create([
            'calendar_id' => $calendar->id,
        ]);

        $policy = new CalendarEventPolicy();
        $this->assertFalse($policy->verifyCalendar($user, $event, $calendar));
    }
}
