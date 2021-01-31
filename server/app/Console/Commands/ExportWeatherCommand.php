<?php

namespace App\Console\Commands;

use App\Services\MetarServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class ExportWeatherCommand extends Command
{
    private $metarService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metar:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export weather';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MetarServiceInterface $metarService)
    {
        $this->metarService = $metarService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = $this->metarService->all();
        // 1) Storage::append
        // 1.1) Get data from storage
        // 1.2) Merge json (array)
        // 1.3) Storage::put new merged array
        Storage::put('filename.json', json_encode($data));
        //convert to json and save to file
        return 0;
    }
}
