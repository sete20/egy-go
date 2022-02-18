<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Helpers\ShipmentPRNG;
use App\Shipment;
use App\ShipmentSetting;
use Illuminate\Http\Request;

class PickupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = \Auth::user();
        $client = Client::whereId($user->userClient->client_id)->first();
        $date = date_create();
        $today = date("Y-m-d");
        if (ShipmentSetting::getVal('def_shipment_code_type') == 'random') {
            $barcode = ShipmentPRNG::get();
        } else {
            $code = '';
            for ($n = 0; $n < ShipmentSetting::getVal('shipment_code_count'); $n++) {
                $code .= '0';
            }
            $m= rand(2, 50);
            $code       =   substr($code, 0, -strlen($m));
            $barcode    =   $code . $m;
        }
      $shipment=   Shipment::create([
            'code'=>$code,
            'status_id'=>1,
            'shipping_date'=>$today,
            'type'=>1,
            'client_address'=>$client->address,
            'payment_type'=>1,
            'paid'=>0,
            'branch_id'=> $client->state->branch->id,
            'payment_method_id'=>11,
            'client_phone'=>$client->follow_up_mobile,
            'from_area_id'=>$client->area_id,
            'from_country_id' => $client->country_id,
            'from_state_id'=> $client->state_id,
            'client_status'=>1,
            'barcode'=>$barcode,
            'client_id'=>$client->id
        ]);
    }
}
