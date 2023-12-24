<?php

use Laravel\Sanctum\Sanctum;
use LearnKit\Lms\Models\Course;
use LearnKit\Lms\Models\Group;
use LearnKit\LmsConnect\Tests\Models\User;
use LearnKit\LmsConnect\Tests\TestCase;
use function Pest\Laravel\getJson;

uses(TestCase::class);

it('can return all users in a group with their scores', function () {
    $team = createTeamAndActivatePlugin();

    $users = User::factory()->count(5)->create();

    $team->users()->sync($users);

    $courses = Course::factory()->count(10)->create();

    $team->courses()->sync($courses);

    $group = Group::factory()
        ->for($team)
        ->hasAttached($users)
        ->create();

    // Simulate a course completion for the first user
    $user = $team->users()->first();
    $course = $team->courses()->first();

    $user->courseScores()
        ->create([
            'course_id' => $course->id,
            'score' => 5,
            'max_score' => 5,
            'achieved' => true,
        ]);

    // Simulate second course partially completed
    $course = $team->courses()->get()[1];

    $user->courseScores()
        ->create([
            'course_id' => $course->id,
            'score' => 3,
            'max_score' => 10,
            'achieved' => false,
        ]);

    //
    Sanctum::actingAs($users[0]);

    $response = getJson(route('lms-connect.team.groups.group.scores', ['team' => $team->slug, 'group' => $group]));

    expect($response->status())
        ->toBe(200)
        ->and($response->json('data'))
        ->toHaveKeys(['name', 'users'])
        ->and($response->json('data.users'))
        ->toHaveCount(5)
        ->and($response->json('data.users')[0])
        ->ray()
        ->toHaveKeys(['id', 'name', 'email', 'phone', 'score']);
});

