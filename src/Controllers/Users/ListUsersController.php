<?php

namespace LearnKit\LmsConnect\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LearnKit\Lms\Models\Team;
use LearnKit\LmsConnect\Resources\UsersCollection;

class ListUsersController extends Controller
{
    public function __invoke(Request $request, Team $team)
    {
        $users = $team->users;

        return UsersCollection::make($users);
    }
}
