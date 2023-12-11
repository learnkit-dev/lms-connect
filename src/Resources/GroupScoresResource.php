<?php

namespace LearnKit\LmsConnect\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \LearnKit\Lms\Models\Group */
class GroupScoresResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'users_count' => $this->users_count,
            'users_started' => $this->users_started,
            'users_achieved' => $this->users_achieved,
        ];
    }
}
