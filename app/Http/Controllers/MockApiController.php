<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class MockApiController extends Controller
{
    public function android(Request $request)
    {
        $receipt = $request->input("receipt");
        $last = substr($receipt , -1);

        $status = (int)$last % 2 == 0 ? false : true;

        if($status){
            $data = [
                "status" => 1,
                "expire-date" => Carbon::now()->setTimezone("-06:00")->format("Y-m-d H:i:s"),
            ];
            return response()->json(["data" => $data]);
        }
        return ["data" => null];
    }

    public function ios(Request $request)
    {
        $receipt = $request->input("receipt");
        $last = substr($receipt , -1);

        $status = (int)$last % 2 == 0 ? false : true;

        if($status){
            $data = [
                "status" => 1,
                "expire-date" => Carbon::now()->setTimezone("-06:00")->format("Y-m-d H:i:s"),
            ];
            return response()->json(["data" => $data]);
        }
        return ["data" => null];
    }
}
