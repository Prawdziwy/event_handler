<?php

namespace Tests\Unit;

use App\Models\Calendar;
use App\Models\User;
use App\Policies\CalendarPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_access_calendar_if_member_or_owner()
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create();
        $calendar->members()->attach($user);

        $policy = new CalendarPolicy();
        $this->assertTrue($policy->access($user, $calendar));
    }

    /** @test */
    public function user_cannot_access_calendar_if_not_member_or_owner()
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create();

        $policy = new CalendarPolicy();
        $this->assertFalse($policy->access($user, $calendar));
    }
}
