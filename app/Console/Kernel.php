<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ComputePaie;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ComputePaie::class,
    ];
}
