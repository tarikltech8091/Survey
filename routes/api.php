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

    	Route::get('/getMSISDN', array('as'=>'getMSISDN', 'uses'=>'ApiController@GetMSISDN'));

    	Route::get('/participateRegistration', array('as'=>'getMSISDN', 'uses'=>'ApiController@participateRegistration'));
    	Route::get('/getParticipateInfo', array('as'=>'Get Participate Info', 'uses'=>'ApiController@getParticipateInfo'));
    	Route::get('/getCampaignInfo', array('as'=>'Get Campaign Info', 'uses'=>'ApiController@getCampaignInfo'));

    	Route::get('/getCampaignParticipateInfo', array('as'=>'Get Campaign Participate Info', 'uses'=>'ApiController@getCampaignParticipateInfo'));

    	Route::get('/getQuestionAnswerInfo', array('as'=>'Get Question Answer Info', 'uses'=>'ApiController@getQuestionAnswerInfo'));


    	Route::get('/getCampaignDetails', array('as'=>'Get Campaign Details', 'uses'=>'ApiController@getCampaignDetails'));
    	Route::get('/getParticipateQuestionInfo', array('as'=>'Get Participate Question Info', 'uses'=>'ApiController@getParticipateQuestionInfo'));

    	Route::get('/participateQuestionAnswerStore', array('as'=>'Participate Question Answer Store', 'uses'=>'ApiController@participateQuestionAnswerStore'));
    	Route::get('/getParticipateQuestionInfo', array('as'=>'Get Participate Question Info', 'uses'=>'ApiController@getParticipateQuestionInfo'));


    	Route::get('/getSurveyerInfo', array('as'=>'Get Surveyer Info', 'uses'=>'ApiController@getSurveyerInfo'));

    	Route::get('/getSurveyerCampaignInfo', array('as'=>'Get Surveyer Campaign Info', 'uses'=>'ApiController@getSurveyerCampaignInfo'));

    	Route::get('/getAllContentCountdown', array('as'=>'Get All Contenrt Countdown', 'uses'=>'ApiController@getAllContentCountdown'));

    	Route::get('/getAllSingleQuestionAnswer', array('as'=>'Get All Single Question Answer', 'uses'=>'ApiController@getAllSingleQuestionAnswer'));

    	Route::get('/getAllSingleQuestionAnswer', array('as'=>'Get All Contenrt Countdown', 'uses'=>'ApiController@getAllSingleQuestionAnswer'));


    	

	});

});

