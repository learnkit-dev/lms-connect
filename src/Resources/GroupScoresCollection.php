<?php

namespace LearnKit\LmsConnect\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \LearnKit\Lms\Models\Group */
class GroupScoresCollection extends ResourceCollection
{
    public $collects = GroupScoresResource::class;

    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
