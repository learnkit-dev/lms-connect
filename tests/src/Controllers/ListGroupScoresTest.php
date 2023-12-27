<?php

use Laravel\Passport\Passport;
use LearnKit\Lms\Models\Group;
use LearnKit\LmsConnect\Tests\Models\User;
use LearnKit\LmsConnect\Tests\TestCase;
use function Pest\Laravel\getJson;

uses(TestCase::class);

it('can return all groups in a given team with scores', function () {
    $team = createTeamAndActivatePlugin();

    Group::factory()
        ->for($team)
        ->count(5)
        ->create();

    $user = User::factory()->create();

    Passport::actingAs($user, scopes: [], guard: 'lms-connect');

    $response = getJson(route('lms-connect.team.groups.scores', ['team' => $team->slug]));

    expect($response->status())
        ->toBe(200)
        ->and($response->json('data'))
        ->toHaveCount(5)
        ->toBeArray()
        ->and($response->json('data')[0])
        ->toHaveKeys(['id', 'name', 'users_count', 'users_started', 'users_achieved']);
});
