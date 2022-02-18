<?php

namespace App\Http\Controllers;

use App\Captain;
use App\Due;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaptainBalanceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {
        $page_name="captains balance";
        if (\Auth::user()->user_type == 'branch') {
          $captains = Captain::where('branch_id', \Auth::user()->userBranch->branch_id)->pluck('id');
            $dues = Transaction::wherein('captain_id',$captains)->with('captain')->paginate(15);
        }else{
            $dues = Transaction::whereNotNull('captain_id')
            ->with('captain')->paginate(15);

        }
        return view('backend.transactions.captain', get_defined_vars());

    }

    public function branches(Request $request)
    {
        $page_name = "captains balance";

        return view('backend.transactions.branchs', get_defined_vars());
    }


    public function due(Request $request)
    {
        $page_name = "captains balance";

        return view('backend.transactions.due', get_defined_vars());
    }
    public function Store(Request $request,Due $due)
    {
       $due->update(['balance'=>0]);
       return redirect()->back();
    }

}
