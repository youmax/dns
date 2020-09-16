<?php

namespace App\Console\Commands;

use App\Models\Domain;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Console\Command;
use Log;

class AutoHttp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autohttp:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch domain Http response and store it in database';

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
        $client = new Client();
        $promises = [];
        $domains = Domain::all();
        foreach ($domains as $domain) {
            $promises[$domain->id] = $client->getAsync($domain->name);
        }
        $responses = Promise\settle($promises)->wait();
        // dd($responses[11]);
        foreach ($responses as $id => $value) {
            $response = [];
            try {
                if ($value['state'] == 'fulfilled') {
                    $response = $value['value'];
                    $response = [
                        'Status_code' => $response->getStatusCode(),
                    ];
                } else {
                    if (method_exists($value['reason'], 'getResponse')) {
                        $response = $value['reason']->getResponse();
                        $response = [
                            'Status_code' => $response->getStatusCode(),
                        ];
                    } else {
                        $response = [
                            'Status_code' => 0,
                        ];
                    }
                }
            } catch (\Error $e) {
                Log::error($id);
                Log::error(json_encode($value));
            }
            // store into domain
            Domain::where('id', $id)->update([
                'http' => $response ?? [],
            ]);
        }

    }
}
