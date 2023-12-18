<?php

namespace LearnKit\LmsConnect\Controllers;

class HealthController
{
    public function __invoke()
    {
        return [
            'status' => 'ok',
        ];
    }
}
