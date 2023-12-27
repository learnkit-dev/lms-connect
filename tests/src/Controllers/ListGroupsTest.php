<?php

use Laravel\Passport\Passport;
use LearnKit\Lms\Models\Group;
use LearnKit\LmsConnect\Tests\Models\User;
use LearnKit\LmsConnect\Tests\TestCase;
use function Pest\Laravel\getJson;

uses(TestCase::class);

it('can return all groups in a given team', function () {
    $team = createTeamAndActivatePlugin();

    Group::factory()
        ->for($team)
        ->count(5)
        ->create();

    $user = User::factory()->create();

    Passport::actingAs($user, guard: 'lms-connect');

    $response = getJson(route('lms-connect.team.groups.list', ['team' => $team->slug]));

    $data = $response->json('data');

    expect($response->status())
        ->toBe(200)
        ->and($data)
        ->toHaveCount(5)
        ->toBeArray()
        ->and($data[0])
        ->toHaveKeys(['id', 'name', 'users_count', 'team_id', 'created_at', 'updated_at'])
        ->and($data[0]['users_count'])
        ->toBe(0);
});
