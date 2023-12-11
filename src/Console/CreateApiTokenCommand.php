<?php

namespace LearnKit\LmsConnect\Console;

use Closure;
use Illuminate\Console\Command;
use function Laravel\Prompts\search;

class CreateApiTokenCommand extends Command
{
    protected $signature = 'lms-connect:create-api-token';

    protected $description = 'Creates a new server API token';

    public function handle(): void
    {
        $user = search(
            label: 'Please select a user',
            options: $this->searchUsers()
        );

        $user = config('lms.user_model')::find($user);

        $token = $user->createToken('server_api_token');

        $this->info("Token generated {$token->plainTextToken}");
    }

    private function searchUsers(): Closure
    {
        return fn(string $value) => config('lms.user_model')::query()
            ->where('email', 'LIKE', "%{$value}%")
            ->pluck()
            ->toArray();
    }
}