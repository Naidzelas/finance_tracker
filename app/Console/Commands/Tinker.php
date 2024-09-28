<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\TinkerHelper;

class Tinker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'helper:tinker {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Console log code snippets from Helpers/TinkerScripts/{file name}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dd(TinkerHelper::tinker($this->argument('name')));
    }
}
