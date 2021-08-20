<?php

namespace App\Http\Controllers;

use App\Models\capsule;
use App\Models\missions;
use Illuminate\Http\Request;

class CapsuleController extends Controller
{
    public function capsules(Request $request){
        $data = capsule::where('showStatus',1);
        if($request->status){
            if($request->status=='active' || $request->status=='retired' || $request->status=='unknown' || $request->status=='etc'){
                $data->where('status',$request->status);
            }
        }
        $data = $data->get();

        foreach ($data as $key=>$value){

            $data[$key]['missions'] = missions::where(['showStatus'=>1,'cid'=>$value->id])->get();
        }

        return response()->json([$data], 200);
    }
    public function capsulesSerial($serial){

        if($serial){

            $data = capsule::where(['showStatus'=>1,'capsule_serial'=>$serial])->get();
            $data['missions'] = missions::where(['showStatus'=>1,'cid'=>$data])->get();
            return response()->json([$data], 200);

        }

    }
}
