<?php

namespace App\Http\Controllers;

use App\Services\AnnouncerService;

class SayController
{
    public function say()
    {
        $words = request()->input('words');
        AnnouncerService::say($words);
    }
}
