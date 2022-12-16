<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Loansystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Loansystem';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will call php artisan ( migrate ,optimize:clear,route:cache,config:cache,config:clear ) command in single command.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->call('migrate');
        $this->call('optimize:clear');
        $this->call('route:cache');
        $this->call('config:cache');
        $this->call('config:clear');
        $this->call('route:clear');
    }
}
