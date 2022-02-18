<?php

namespace App\Http\Controllers;

use App\State;
use App\StatePrice;
use Illuminate\Http\Request;

class StatePriceController extends Controller
{

    public function index()
    {
        $page_name = translate('All States price');

        $states= State::whereHas('price')->where('country_id',65)->paginate(10);
        return view('backend.state_price.index',get_defined_vars());
    }


    public function create()
    {
        $states = State::doesntHave('price')->where('country_id', 65)->get();
        return view('backend.state_price.create', get_defined_vars());

    }


    public function store(Request $request)
    {
        $request->validate([
            'price'=>'required|numeric',
            'state_id'=>'required|exists:states,id'
        ]);
        StatePrice::create($request->all());
        return redirect()->route('price.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $price = StatePrice::whereId($id)->first();
        return view('backend.state_price.edit', get_defined_vars());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric',
        ]);
        $price =StatePrice::whereId($id)->first();
        $price->update(['price'=>$request->price]);
        return redirect()->route('price.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $statePrice = StatePrice::whereId($id)->delete();
        return redirect()->back();
    }
}
