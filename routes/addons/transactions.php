<?php

use App\Http\Helpers\TransactionHelper;


Route::group(['prefix' =>'admin', 'middleware' => ['auth', 'user_role:admin|staff|branch']], function(){
	//Update Routes
	Route::get('clients/transactions/{client_id}','TransactionController@getClientTransaction')->name('admin.client.transactions.show');
	Route::get('captains/transactions/{captain_id}','TransactionController@getCaptainTransaction')->name('admin.captain.transactions.show');
    Route::resource('transactions','TransactionController',[
        'as' => 'admin'
    ]);
    Route::get('/captain/balance', 'CaptainBalanceController@index')->name('captain.index');
    Route::get('/branch/balance', 'CaptainBalanceController@branches')->name('branch.index');
    Route::get('/branch/due', 'CaptainBalanceController@due')->name('branch.due');

    Route::post('/captain/balance/create/{due}', 'CaptainBalanceController@store')->name('captain.store');
    Route::get('/client/supply', 'SupplyBalanceController@index')->name('client.supply.index');
    Route::post('/client/supply/{transaction}', 'SupplyBalanceController@store')->name('client.supply.store');


});
Route::get('admin/reverce_config',function(){

	$str = file_get_contents(base_path('addons/spot-cargo-shipment-addon/config.json'));
	$config = json_decode($str, true);
	if (!empty($config['files'])) {
		foreach ($config['files'] as $file) {
			copy(base_path($file['update_directory']), base_path($file['root_directory']));
		}
	}
});
