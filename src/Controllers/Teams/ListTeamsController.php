<?php

namespace LearnKit\LmsConnect\Controllers\Teams;

use Illuminate\Routing\Controller;
use LearnKit\Lms\Models\Team;
use LearnKit\LmsConnect\Resources\TeamCollection;

class ListTeamsController extends Controller
{
    public function __invoke()
    {
        $teams = Team::withCount('users')->get();

        return TeamCollection::make($teams);
    }
}
