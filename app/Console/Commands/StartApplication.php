<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartApplication extends Command
{
    protected $signature = 'app:start';
    protected $description = 'Start the Laravel application';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting the Laravel application...');

        $command = 'php -S localhost:8000 -t public';

        exec("start /B $command", $output, $status);

        if ($status === 0) {
            $this->info('Application started successfully.');
        } else {
            $this->error('Failed to start the application.');
        }

        return 0;
    }
}
