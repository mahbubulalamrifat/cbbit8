<?php

namespace App\Console\Commands\Notification;

use Illuminate\Console\Command;

use App\Http\Controllers\Notification\IndexController;

class Pendings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Pendings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        
       $obj = new IndexController(); 
       $obj->pendingNotify();
    }
}
