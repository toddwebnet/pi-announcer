<?php

namespace App\Console\Commands;

use App\Services\AnnouncerService;
use Illuminate\Console\Command;

class SaySomething extends Command
{

    protected $signature = 'say {words}';

    public function handle()
    {
        AnnouncerService::say($this->argument('words'));
        return response()->json([], 200);
    }
}
