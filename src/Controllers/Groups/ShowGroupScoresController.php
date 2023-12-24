<?php

namespace LearnKit\LmsConnect\Controllers\Groups;

use Illuminate\Routing\Controller;
use LearnKit\Lms\Models\Contracts\LmsUser;
use LearnKit\Lms\Models\Group;
use LearnKit\Lms\Models\Team;

class ShowGroupScoresController extends Controller
{
    public function __invoke(Team $team, Group $group)
    {
        $courseIds = $team->courses->pluck('id');
        $courseCount = count($courseIds);

        $users = $group->users()
            ->with(['courseScores' => function ($query) use ($courseIds) {
                return $query
                    ->whereIn('course_id', $courseIds);
            }])
            ->get()
            ->map(function (LmsUser $user) use ($courseCount) {
                $relativeScores = $user->courseScores->pluck('relative_score')->values()->toArray();

                $scores = array_sum($relativeScores);

                $globalRelativeScore = ($courseCount === 0) ? 0 : $scores / $courseCount;

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'score' => $globalRelativeScore,
                ];
            });

        return [
            'data' => [
                'name' => $group->name,
                'users' => $users,
            ],
        ];
    }
}
