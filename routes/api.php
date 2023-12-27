<?php

use Illuminate\Support\Facades\Route;
use LearnKit\LmsConnect\Controllers\Auth\UserOAuthController;
use LearnKit\LmsConnect\Controllers\Groups\ListGroupsController;
use LearnKit\LmsConnect\Controllers\Groups\ListGroupScoresController;
use LearnKit\LmsConnect\Controllers\Groups\ShowGroupScoresController;
use LearnKit\LmsConnect\Controllers\HealthController;
use LearnKit\LmsConnect\Controllers\Users\ListUsersController;
use LearnKit\LmsConnect\Middleware\PluginEnabledMiddleware;

Route::group([
    'prefix' => 'lms-connect/api/v1',
    'middleware' => ['api', 'throttle:api', 'auth:lms-connect'],
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

Route::group([
    'as' => 'passport.',
    'prefix' => 'oauth',
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {

    Route::post('/token', [
        'uses' => 'AccessTokenController@issueToken',
        'as' => 'token',
        'middleware' => 'throttle',
    ]);

    Route::get('/authorize', [
        'uses' => 'AuthorizationController@authorize',
        'as' => 'authorizations.authorize',
        'middleware' => 'web',
    ]);

    $guard = config('passport.guard', null);

    Route::middleware(['web', $guard ? 'auth:'.$guard : 'auth'])->group(function () {
        Route::post('/token/refresh', [
            'uses' => 'TransientTokenController@refresh',
            'as' => 'token.refresh',
        ]);

        Route::post('/authorize', [
            'uses' => 'ApproveAuthorizationController@approve',
            'as' => 'authorizations.approve',
        ]);

        Route::delete('/authorize', [
            'uses' => 'DenyAuthorizationController@deny',
            'as' => 'authorizations.deny',
        ]);

        Route::get('/tokens', [
            'uses' => 'AuthorizedAccessTokenController@forUser',
            'as' => 'tokens.index',
        ]);

        Route::delete('/tokens/{token_id}', [
            'uses' => 'AuthorizedAccessTokenController@destroy',
            'as' => 'tokens.destroy',
        ]);

        Route::get('/clients', [
            'uses' => 'ClientController@forUser',
            'as' => 'clients.index',
        ]);

        Route::post('/clients', [
            'uses' => 'ClientController@store',
            'as' => 'clients.store',
        ]);

        Route::put('/clients/{client_id}', [
            'uses' => 'ClientController@update',
            'as' => 'clients.update',
        ]);

        Route::delete('/clients/{client_id}', [
            'uses' => 'ClientController@destroy',
            'as' => 'clients.destroy',
        ]);

        Route::get('/scopes', [
            'uses' => 'ScopeController@all',
            'as' => 'scopes.index',
        ]);

        Route::get('/personal-access-tokens', [
            'uses' => 'PersonalAccessTokenController@forUser',
            'as' => 'personal.tokens.index',
        ]);

        Route::post('/personal-access-tokens', [
            'uses' => 'PersonalAccessTokenController@store',
            'as' => 'personal.tokens.store',
        ]);

        Route::delete('/personal-access-tokens/{token_id}', [
            'uses' => 'PersonalAccessTokenController@destroy',
            'as' => 'personal.tokens.destroy',
        ]);
    });
});

Route::group(['prefix' => 'oauth', 'middleware' => ['auth:lms-connect']], function () {
    Route::get('user', [UserOAuthController::class, 'user'])->name('user');
    Route::delete('revoke', [UserOAuthController::class, 'revoke'])->name('revoke');
});
