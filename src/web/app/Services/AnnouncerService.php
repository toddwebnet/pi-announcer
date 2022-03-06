<?php

namespace App\Services;

class AnnouncerService
{
    public static function say($words)
    {
        $dropPath = realpath(env('ANNOUNCER_DROP_PATH'));
        $file = $dropPath . '/' . time() .'.txt';
        file_put_contents($file, $words);
    }
}
