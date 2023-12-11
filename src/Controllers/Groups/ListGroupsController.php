<?php

namespace LearnKit\LmsConnect\Controllers\Groups;

use Illuminate\Routing\Controller;
use LearnKit\Lms\Models\Team;
use LearnKit\LmsConnect\Resources\GroupCollection;

class ListGroupsController extends Controller
{
    public function __invoke(Team $team)
    {
        $groups = $team->groups()->withCount('users')->get();

        return GroupCollection::make($groups);
    }
}
