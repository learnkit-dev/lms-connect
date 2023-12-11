<?php

use Laravel\Sanctum\Sanctum;
use LearnKit\Lms\Models\Team;
use LearnKit\LmsConnect\Tests\Models\User;
use LearnKit\LmsConnect\Tests\TestCase;
use function Pest\Laravel\getJson;

uses(TestCase::class);

it('can return all teams in the LMS', function () {
    Team::factory()->count(5)->create();
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = getJson(route('lms-connect.teams.list'));

    $data = $response->json('data');

    expect($data)
        ->toHaveCount(5)
        ->toBeArray()
        ->and($data[0])
        ->toHaveKeys(['id', 'name', 'slug', 'users_count']);
})->todo();
