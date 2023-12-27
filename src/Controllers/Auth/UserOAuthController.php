<?php

namespace LearnKit\LmsConnect\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class UserOAuthController extends Controller
{
    public function user(Request $request)
    {
        $user = $request->user();

        return [
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'teams' => $user->lmsTeams()->pluck('slug'),
            ],
        ];
    }

    public function revoke(Request $request)
    {
        $token = $request->user()->token();

        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $tokenRepository->revokeAccessToken($token->id);

        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
    }
}