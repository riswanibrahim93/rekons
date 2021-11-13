<?php

namespace App\Console\Commands;

use App\Models\Branch;
use App\Models\Data;
use App\Models\Filing;
use App\Models\Notification;
use App\Models\ReconciledData;
use Illuminate\Console\Command;

class ResetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sssssssssss';

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
        Branch::truncate();
        Data::truncate();
        Filing::truncate();
        Notification::truncate();
        ReconciledData::truncate();
        // us::truncate();
        return Command::SUCCESS;
    }
}
