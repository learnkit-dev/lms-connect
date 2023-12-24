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
            ->map(function (LmsUser $user) use ($team, $courseCount) {
                $relativeScores = $user->courseScores->pluck('relative_score')->values()->toArray();

                $scores = array_sum($relativeScores);

                $globalRelativeScore = ($courseCount === 0) ? 0 : $scores / $courseCount;

                $courses = $team->courses
                    ->map(function ($course) use ($user) {
                        $courseScore = $user->courseScores->firstWhere('course_id', $course->id);

                        $state = false;
                        $relativeScore = 0;

                        if ($courseScore) {
                            $state = $courseScore['achieved'] ? true : false;
                            $relativeScore = $courseScore['relative_score'];
                        }

                        return [
                            'id' => $course->id,
                            'name' => $course->name,
                            'achieved' => $state,
                            'score' => $relativeScore * 100,
                        ];
                    })
                    ->toArray();

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'lms_roles' => $user->lms_roles,
                    'last_seen_at' => $user->last_seen_at,
                    'created_at' => $user->created_at,
                    'score' => $globalRelativeScore * 100,
                    'courses' => $courses,
                ];
            })
            ->toArray();

        return [
            'data' => [
                'name' => $group->name,
                'users' => $users,
            ],
        ];
    }
}
