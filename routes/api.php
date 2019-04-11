<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => '/v1','middleware' => ['api']], function() {


    #Token
    Route::get('/getAccessToken', array('as'=>'GetToken', 'uses'=>'ApiController@GetAccessToken'));
    #MSISDN CHECK
    Route::get('/getMSISDN', array('as'=>'getMSISDN', 'uses'=>'ApiController@GetMSISDN'));

	Route::get('getdata',function (){
        echo "Hello API";
    });

	Route::group(['middleware' => 'jwt-auth'], function () {

	   	Route::get('hello',function (){
	        echo "Hello All";
	    });

	   	Route::post('getdata',function (){
	        echo "Hello API";
	    });

	});

});

