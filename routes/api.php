<?php

use Illuminate\Support\Facades\Route;
use LearnKit\LmsConnect\Controllers\Groups\ListGroupsController;
use LearnKit\LmsConnect\Controllers\Groups\ListGroupScoresController;
use LearnKit\LmsConnect\Controllers\Groups\ShowGroupScoresController;
use LearnKit\LmsConnect\Controllers\HealthController;
use LearnKit\LmsConnect\Controllers\Users\ListUsersController;
use LearnKit\LmsConnect\Middleware\PluginEnabledMiddleware;

Route::group([
    'prefix' => 'lms-connect/api/v1',
    'middleware' => ['api', 'throttle:api', 'auth:sanctum'],
    'as' => 'lms-connect.',
], function () {

    Route::get('health', HealthController::class)->name('health');

    Route::prefix('{team}')
        ->as('team.')
        ->middleware([PluginEnabledMiddleware::class])
        ->group(function () {

            Route::get('groups', ListGroupsController::class)->name('groups.list');

            Route::get('groups/scores', ListGroupScoresController::class)->name('groups.scores');

            Route::get('groups/{group}/scores', ShowGroupScoresController::class)->name('groups.group.scores');

            Route::get('users', ListUsersController::class)->name('users.list');

        });

});
