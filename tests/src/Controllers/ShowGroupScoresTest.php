<?php

use Laravel\Sanctum\Sanctum;
use LearnKit\Lms\Models\Group;
use LearnKit\LmsConnect\Tests\Models\User;
use LearnKit\LmsConnect\Tests\TestCase;
use function Pest\Laravel\getJson;

uses(TestCase::class);

it('can return all users in a group with their scores', function () {
    $team = createTeamAndActivatePlugin();

    $group = Group::factory()
        ->for($team)
        ->has(
            User::factory()->count(5)
        )
        ->create();

    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = getJson(route('lms-connect.team.groups.group.scores', ['team' => $team->slug, 'group' => $group]));

    expect($response->status())
        ->toBe(200)
        ->and($response->json('data'))
        ->toHaveKeys(['name', 'users'])
        ->and($response->json('data.users'))
        ->toHaveCount(5)
        ->and($response->json('data.users')[0])
        ->toHaveKeys(['id', 'name', 'email', 'phone', 'score']);
});
