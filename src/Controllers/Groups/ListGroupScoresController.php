<?php

namespace LearnKit\LmsConnect\Controllers\Groups;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LearnKit\Lms\Models\Team;
use LearnKit\LmsConnect\Resources\GroupScoresCollection;

class ListGroupScoresController extends Controller
{
    public function __invoke(Request $request, Team $team)
    {
        $groups = $team->groups()
            ->withCount('users')
            ->report(
                team: $team,
            )
            ->get();

        return GroupScoresCollection::make($groups);
    }
}
