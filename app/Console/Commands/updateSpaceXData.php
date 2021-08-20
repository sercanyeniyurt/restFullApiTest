<?php

namespace App\Console\Commands;

use App\Models\capsule;
use App\Models\missions;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class updateSpaceXData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateSpaceXData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update SpaceX Data';

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
        $response = Http::get('https://api.spacexdata.com/v3/capsules');
        if($response->successful()){
            if($response->body()){
                $data = json_decode($response->body());
                if($data){
                    foreach ($data as $dat){

                        $capsule = capsule::create([
                            'capsule_serial'=>$dat->capsule_serial,
                            'capsule_id'=>$dat->capsule_id,
                            'status'=>$dat->status,
                            'original_launch'=>$dat->original_launch,
                            'original_launch_unix'=>$dat->original_launch_unix,
                            'landings'=>$dat->landings,
                            'type'=>$dat->type,
                            'details'=>$dat->details,
                            'reuse_count'=>$dat->reuse_count
                        ]);

                        if($dat->missions){
                            foreach ($dat->missions as $mission){

                                missions::create([
                                    'cid'=>$capsule->id,
                                    'name'=>$mission->name,
                                    'flight'=>$mission->flight
                                ]);
                            }
                        }

                    }

                    /*
                     *
                     * When the process is finished, we delete the old ones and activate the new ones.
                     * Because during this process, if they want to read data, the data should not return empty.
                     *
                     */

                    missions::where('showStatus',1)->delete();
                    capsule::where('showStatus',1)->delete();
                    missions::where('showStatus',0)->update(['showStatus'=>1]);
                    capsule::where('showStatus',0)->update(['showStatus'=>1]);
                    Storage::disk('public')->put('/spacex/'.Carbon::now()->format('d.m.Y_H_i_s').'.json', $response->body());

                    return 'Capsule datas updated.';
                }
            } else {
                return 'The content could not be read.';
            }
        } else {
            return 'API could not be accessed.';
        }
    }
}
