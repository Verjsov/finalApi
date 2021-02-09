<?php

namespace App\Console\Commands;

use App\Models\Station;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AddNewStationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metar:add {icao : The ICAO code consists of 4 characters}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adding to new station ICAO';

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
        $code = Str::upper($this->argument('icao'));
        $validator = Validator::make(['code' => $code],[
            'code' => 'min:4|max:4|unique:stations,icao',
        ]);
        if ($validator->fails()) {
            $this->info('ICAO code not created. See error messages below:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }
        $station = new Station();
        $station->icao = $code;
        $station->save();
        $this->info("$code code station created!");
        return 0;
    }
}
