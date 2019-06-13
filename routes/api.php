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




    	Route::post('/participateRegistration', array('as'=>'Participate Registration', 'uses'=>'ApiController@participateRegistration'));

    	Route::post('/SurveyerOrRequesterLogin', array('as'=>'Surveyer Or Requester Login', 'uses'=>'ApiController@SurveyerOrRequesterLogin'));

    	Route::post('/getParticipateInfo', array('as'=>'Get Participate Info', 'uses'=>'ApiController@getParticipateInfo'));

    	Route::post('/getCampaignInfo', array('as'=>'Get Campaign Info', 'uses'=>'ApiController@getCampaignInfo'));

    	Route::post('/getCampaignParticipateInfo', array('as'=>'Get Campaign Participate Info', 'uses'=>'ApiController@getCampaignParticipateInfo'));

    	Route::post('/getQuestionAnswerInfo', array('as'=>'Get Question Answer Info', 'uses'=>'ApiController@getQuestionAnswerInfo'));


    	Route::post('/getCampaignDetails', array('as'=>'Get Campaign Details', 'uses'=>'ApiController@getCampaignDetails'));
    	
        Route::post('/getParticipateQuestionInfo', array('as'=>'Surveyer Registration', 'uses'=>'ApiController@getParticipateQuestionInfo'));

    	Route::post('/surveyerRegistration', array('as'=>'Surveyer Registration', 'uses'=>'ApiController@surveyerRegistration'));

    	Route::post('/participateQuestionAnswerStore', array('as'=>'Participate Question Answer Store', 'uses'=>'ApiController@participateQuestionAnswerStore'));
    	
    	Route::post('/ParticipateQuestionInfo', array('as'=>'Get Participate Question Info', 'uses'=>'ApiController@ParticipateQuestionInfo'));








    	Route::post('/getSurveyerInfo', array('as'=>'Get Surveyer Info', 'uses'=>'ApiController@getSurveyerInfo'));

    	Route::post('/getSurveyerCampaignInfo', array('as'=>'Get Surveyer Campaign Info', 'uses'=>'ApiController@getSurveyerCampaignInfo'));

    	Route::post('/getSurveyerAllContentCountdown', array('as'=>'Get Surveyer All Contenrt Countdown', 'uses'=>'ApiController@getSurveyerAllContentCountdown'));

    	Route::post('/getAllSingleQuestionAnswer', array('as'=>'Get All Single Question Answer', 'uses'=>'ApiController@getAllSingleQuestionAnswer'));

    	Route::post('/getSurveyerPaymentInfo', array('as'=>'Get Surveyer Payment Info', 'uses'=>'ApiController@getSurveyerPaymentInfo'));

    	Route::post('/getSurveyerQuestionAnswerList', array('as'=>'Get Surveyer Question Answer List', 'uses'=>'ApiController@getSurveyerQuestionAnswerList'));

    	Route::post('/getCampaignFirstQuestionInfo', array('as'=>'Get Campaign First Question Info', 'uses'=>'ApiController@getCampaignFirstQuestionInfo'));

    	Route::post('/FirstQuestionAnswerStore', array('as'=>'First Question Answer Store', 'uses'=>'ApiController@FirstQuestionAnswerStore'));

    	Route::post('/getCampaignQuestionInfo', array('as'=>'Get Campaign Question Info', 'uses'=>'ApiController@getCampaignQuestionInfo'));

    	Route::post('/QuestionAnswerStore', array('as'=>'Question Answer Store', 'uses'=>'ApiController@QuestionAnswerStore'));







        Route::post('/requesterRegistration', array('as'=>'Requester Registration', 'uses'=>'ApiController@requesterRegistration'));

    	Route::post('/RequesterAllContentCountdown', array('as'=>'Requester All Content Countdown', 'uses'=>'ApiController@RequesterAllContentCountdown'));

    	Route::post('/getRequesterAllSingleQuestionAnswer', array('as'=>'Requester All Single Question Answer', 'uses'=>'ApiController@getRequesterAllSingleQuestionAnswer'));

    	Route::post('/RequesterPaymentList', array('as'=>'Requester Payment List', 'uses'=>'ApiController@RequesterPaymentList'));

    	Route::post('/RequesterCampaignList', array('as'=>'Requester Campaign List', 'uses'=>'ApiController@RequesterCampaignList'));


    	

	});

});

