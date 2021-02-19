<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevicePurchaseRequest;
use App\Http\Requests\DeviceRegisterRequest;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeviceController extends Controller
{
    /**
     * @param DeviceRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(DeviceRegisterRequest $request)
    {
        $uid = $request->input("uid");
        $device = Device::query()->firstWhere("uid",$uid);

        if($device){
            $token = $device->createToken("device-token");

            return response()->json([
                "status" => "OK",
                "client-token" => $token->plainTextToken
            ]);
        }

       $newDevice = Device::query()->create($request->only(["uid","appId","language","os"]));
       $newToken = $newDevice->createToken("device-token");

        return response()->json([
            "status" => "OK",
            "client-token" => $newToken->plainTextToken
        ]);
    }

    /**
     * @param DevicePurchaseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchase(DevicePurchaseRequest $request)
    {
        $device = $request->user();
        $data = null;

        // Android
        if($device->os == "android"){

            $response = Http::withHeaders([
                "username" => config("subscription.android.username"),
                "password" => config("subscription.android.password")
            ])->post(url("/")."/mockapi/android", [
                'receipt' => $request->input("receipt"),
            ]);

            if($response->status() == 200 && $response->object()){
                $getData = $response->object()->data;
                if($getData){
                    $data = $getData;
                }
            }
        }

        // ios
        if($device->os == "ios"){

            $response = Http::withHeaders([
                "username" => config("subscription.ios.username"),
                "password" => config("subscription.ios.password")
            ])->post(url("/")."/mockapi/ios", [
                'receipt' => $request->input("receipt"),
            ]);

            if($response->status() == 200 && $response->object()){
                $getData = $response->object()->data;
                if($getData){
                    $data = $getData;
                }
            }
        }

        // DB insert
        $subscription = $device->subscription;

        if($data){
            if(!$device->subscription){
                $subscription = $device->subscription()->create([
                    "expire-date" => $data->{"expire-date"},
                    "status" => $data->status
                ]);
            }

            return response()->json([
                "status" => 1,
                "expire-date" => $subscription->{"expire-date"},
            ]);
        }

        return response()->json([
            "status" => 0,
        ]);

    }

    public function checkSubscription(Request $request)
    {
        $device = $request->user();
        $subscription = $device->subscription;

        if($subscription->status){
            return response()->json([
                "status" => 1,
                "expire-date" => $subscription->{"expire-date"},
            ]);
        }

        return response()->json([
            "status" => 0,
            "expire-date" => $subscription->{"expire-date"},
        ]);
    }
}
