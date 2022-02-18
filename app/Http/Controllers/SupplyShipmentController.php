<?php

namespace App\Http\Controllers;

use App\Client;
use App\Shipment;
use App\Transaction;
use Illuminate\Http\Request;

class SupplyShipmentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Shipment $shipment)
    {
        $shipment->update(['status_id'=>10]);

        Transaction::create([
            'value'=>$shipment->amount_to_be_supply,
            'client_id'=>$shipment->client_id
        ]);
       return redirect()->back();
    }
}
