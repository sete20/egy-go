<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class SupplyBalanceController extends Controller
{
    public function index(){

        return view('backend.transactions.client');
    }
    public function store(Transaction $transaction)
    {
        $transaction->update(['status'=>'done']);
        return redirect()->back();
    }

}
