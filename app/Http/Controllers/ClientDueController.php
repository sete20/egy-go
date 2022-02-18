<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Transaction;
class ClientDueController extends Controller
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
        $transactions = \App\Transaction::where('client_id', \Auth::user()->userClient->client_id)->where('status', 'none')->get();
        foreach ($transactions as $key => $transaction) {
            $transaction->update(['status'=>'pending']);
        }
    }
}
