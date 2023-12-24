<?php

namespace LearnKit\LmsConnect\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use LearnKit\Lms\Concerns\HasLmsAccess;
use LearnKit\Lms\Models\Contracts\LmsUser;
use LearnKit\LmsConnect\Tests\Database\Factories\UserFactory;

class User extends Authenticatable implements LmsUser
{
    use HasApiTokens, HasFactory, HasLmsAccess;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}