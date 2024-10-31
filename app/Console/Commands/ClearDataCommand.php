<?php

namespace App\Console\Commands;

use App\Models\HistoryBuy;
use Illuminate\Console\Command;

class ClearDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:data {day}';

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
        $day = $this->argument('day') ?? 7;
        $s = HistoryBuy::where('created_at', '<=', now()->subDays($day))->delete();
    }
}
