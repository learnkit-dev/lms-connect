<?php

namespace LearnKit\LmsConnect;

use LearnKit\Lms\BasePlugin;
use LearnKit\Lms\Contracts\PluginContract;

class ConnectPlugin extends BasePlugin implements PluginContract
{
    public static function getComposerName(): string
    {
        return 'learnkit/lms-connect';
    }


    public static function getCode(): string
    {
        return 'connect';
    }

    public static function getLabel(): string
    {
        return 'Connect Plugin';
    }
}