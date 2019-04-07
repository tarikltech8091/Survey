<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteSurveyerProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/



	Route::get('/login',array('as'=>'LogIn' , 'uses' =>'SystemController@LoginPage'));
	Route::post('/login',array('as'=>'LogIn' , 'uses' =>'SystemController@AuthenticationCheck'));

      Route::get('/dashboard',array('as'=>'Dashboard' , 'uses' =>'SystemAuthController@Dashboard'));

	#Admin logut
	Route::get('/logout/{name_slug}',array('as'=>'Logout' , 'uses' =>'SystemController@Logout'));

	#Enternal Error Page
	Route::get('/error/request',array('as'=>'Error 404', 'desc'=>'internal & data error', 'uses'=>'SystemController@ErrorRequestPage'));
	#Errors Page
	Route::get('/errors/page',array('as'=>'Errors Page', 'desc'=>'view & detail', 'uses'=>'SystemController@Page404'));
      
      Route::get('/',array('as'=>'LogIn' , 'uses' =>'SystemAuthController@authLogin'));

	Route::get('/auth',array('as'=>'Sign in', 'uses' =>'SystemAuthController@authLogin'));
	Route::get('auth/login',array('as'=>'Sign in', 'uses' =>'SystemAuthController@authLogin'));
	Route::post('auth/post/login',array('as'=>'Sign in' , 'uses' =>'SystemAuthController@authPostLogin'));
	Route::post('auth/registration',array('as'=>'Registration' , 'uses' =>'SystemAuthController@authRegistration'));
	Route::post('auth/forget/password',array('as'=>'Forgot Password' , 'uses' =>'SystemAuthController@authForgotPasswordConfirm'));
	Route::get('auth/set/new/password/{user_id}/verify',array('as'=>'Forgot Password Verify' , 'uses' =>'SystemAuthController@authSystemForgotPasswordVerification'));
	Route::post('auth/post/new/password/',array('as'=>'New Password Submit' , 'uses' =>'SystemAuthController@authSystemNewPasswordPost'));
      Route::get('auth/admin/logout/{email}',array('as'=>'Logout' , 'uses' =>'SystemAuthController@authLogout'));
      Route::get('/logout',array('as'=>'Logout' , 'uses' =>'SystemAuthController@authLogout'));


      Route::get('/hello',array('as'=>'hello' , 'uses' =>'PortalQuestionController@getAllContent'));




    /*
  #####################
  ## Admins Module
  ######################
  */
  Route::group(['middleware' => ['admin_auth']], function () {


      Route::get('/admin/profile',array('as'=>'Admin Profile' , 'uses' =>'AdminController@Profile'));
      Route::get('/admin/user/management',array('as'=>'Admin User management' , 'uses' =>'AdminController@UserManagement'));



      /*################
      ## Surveyer Settings
      #################*/

      #getAllContent
      Route::get('/surveyer/list',array('as'=>'Get All Surveyer Content' , 'desc'=>'entry & Edit', 'uses' =>'SurveyerController@getAllContent'));
      #Create
      Route::get('/surveyer/create',array('as'=>'Surveyer Create' , 'desc'=>'entry & edit', 'uses' =>'SurveyerController@Create'));
      #Store
      Route::post('/surveyer/save',array('as'=>'Surveyer Save' , 'desc'=>'entry & edit', 'uses' =>'SurveyerController@Store'));
      #ChangeStatus
      Route::get('/surveyer/change/status/{id}/{status}',array('as'=>'Surveyer Status Change' , 'desc'=>'entry & edit', 'uses' =>'SurveyerController@ChangePublishStatus'));
      #Edit
      Route::get('/surveyer/edit/id-{id}',array('as'=>'Surveyer Edit' , 'desc'=>'entry & edit', 'uses' =>'SurveyerController@Edit'));
      #Update
      Route::post('/surveyer/update/id-{id}',array('as'=>'Surveyer Update' , 'desc'=>'entry & edit', 'uses' =>'SurveyerController@Update'));
      #Delete
      Route::get('/surveyer/delete/id-{id}',array('as'=>'Surveyer Delete' , 'desc'=>'entry & edit', 'uses' =>'SurveyerController@Delete'));




      /*################
      ## Requester Settings
      #################*/

      #getAllContent
      Route::get('/requester/list',array('as'=>'Get All Requester Content' , 'desc'=>'entry & Edit', 'uses' =>'RequesterController@getAllContent'));
      #Create
      Route::get('/requester/create',array('as'=>'Requester Create' , 'desc'=>'entry & edit', 'uses' =>'RequesterController@Create'));
      #Store
      Route::post('/requester/save',array('as'=>'Requester Save' , 'desc'=>'entry & edit', 'uses' =>'RequesterController@Store'));
      #ChangeStatus
      Route::get('/requester/change/status/{id}/{status}',array('as'=>'Requester Status Change' , 'desc'=>'entry & edit', 'uses' =>'RequesterController@ChangePublishStatus'));
      #Edit
      Route::get('/requester/edit/id-{id}',array('as'=>'Requester Edit' , 'desc'=>'entry & edit', 'uses' =>'RequesterController@Edit'));
      #Update
      Route::post('/requester/update/id-{id}',array('as'=>'Requester Update' , 'desc'=>'entry & edit', 'uses' =>'RequesterController@Update'));
      #Delete
      Route::get('/requester/delete/id-{id}',array('as'=>'Requester Delete' , 'desc'=>'entry & edit', 'uses' =>'RequesterController@Delete'));




      /*################
      ## Participate Settings
      #################*/

      #getAllContent
      Route::get('/participate/list',array('as'=>'Get All Participate Content' , 'desc'=>'entry & Edit', 'uses' =>'ParticipateController@getAllContent'));
      #Create
      Route::get('/participate/create',array('as'=>'Participate Create' , 'desc'=>'entry & edit', 'uses' =>'ParticipateController@Create'));
      #Store
      Route::post('/participate/save',array('as'=>'Participate Save' , 'desc'=>'entry & edit', 'uses' =>'ParticipateController@Store'));
      #ChangeStatus
      Route::get('/participate/change/status/{id}/{status}',array('as'=>'Participate Status Change' , 'desc'=>'entry & edit', 'uses' =>'ParticipateController@ChangePublishStatus'));
      #Edit
      Route::get('/participate/edit/id-{id}',array('as'=>'Participate Edit' , 'desc'=>'entry & edit', 'uses' =>'ParticipateController@Edit'));
      #Update
      Route::post('/participate/update/id-{id}',array('as'=>'Participate Update' , 'desc'=>'entry & edit', 'uses' =>'ParticipateController@Update'));
      #Delete
      Route::get('/participate/delete/id-{id}',array('as'=>'Participate Delete' , 'desc'=>'entry & edit', 'uses' =>'ParticipateController@Delete'));




      /*################
      ## Campaign Settings
      #################*/

      #getAllContent
      Route::get('/campaign/list',array('as'=>'Get All Campaign Content' , 'desc'=>'entry & Edit', 'uses' =>'CampaignController@getAllContent'));
      #Create
      Route::get('/campaign/create',array('as'=>'Campaign Create' , 'desc'=>'entry & edit', 'uses' =>'CampaignController@Create'));
      #Store
      Route::post('/campaign/save',array('as'=>'Campaign Save' , 'desc'=>'entry & edit', 'uses' =>'CampaignController@Store'));
      #ChangeStatus
      Route::get('/campaign/change/status/{id}/{status}',array('as'=>'Campaign Status Change' , 'desc'=>'entry & edit', 'uses' =>'CampaignController@ChangePublishStatus'));
      #Edit
      Route::get('/campaign/edit/id-{id}',array('as'=>'Campaign Edit' , 'desc'=>'entry & edit', 'uses' =>'CampaignController@Edit'));
      #Update
      Route::post('/campaign/update/id-{id}',array('as'=>'Campaign Update' , 'desc'=>'entry & edit', 'uses' =>'CampaignController@Update'));
      #Delete
      Route::get('/campaign/delete/id-{id}',array('as'=>'Campaign Delete' , 'desc'=>'entry & edit', 'uses' =>'CampaignController@Delete'));



      /*################
      ## Campaign Payment Settings
      #################*/

      #CampaignPaymentList
      Route::get('/campaign/payment/list',array('as'=>'Campaign Payment List' , 'desc'=>'entry & edit', 'uses' =>'PaymentController@CampaignPaymentList'));

      #CampaignPayment
      Route::get('/campaign/payment',array('as'=>'Campaign Payment' , 'desc'=>'entry & edit', 'uses' =>'PaymentController@CampaignPayment'));

      #CampaignPaymentStore
      Route::post('/campaign/payment/save',array('as'=>'Campaign Payment Save' , 'desc'=>'entry & edit', 'uses' =>'PaymentController@CampaignPaymentStore'));

      #CampaignPaymentChangeStatus
      Route::get('/campaign/payment/change/status/{id}/{status}',array('as'=>'Campaign Payment Status Change' , 'desc'=>'entry & edit', 'uses' =>'PaymentController@ChangeCampaignPaymentStatus'));

      #CampaignPaymentEdit
      Route::get('/campaign/payment/edit/id-{id}',array('as'=>'Campaign Payment Edit' , 'desc'=>'entry & edit', 'uses' =>'PaymentController@CampaignPaymentEdit'));

      #CampaignPaymentUpdate
      Route::post('/campaign/payment/update/id-{id}',array('as'=>'Campaign Payment Update' , 'desc'=>'entry & edit', 'uses' =>'PaymentController@CampaignPaymentUpdate'));



      /*################
      ## Surveyer Assign Settings
      #################*/

      #getAllContent
      Route::get('/surveyer/assign/list',array('as'=>'Surveyer Assign List' , 'desc'=>'entry & edit', 'uses' =>'SurveyerAssignController@getAllContent'));

      #Create
      Route::get('/surveyer/assign',array('as'=>'Surveyer Assign' , 'desc'=>'entry & edit', 'uses' =>'SurveyerAssignController@Create'));

      #Store
      Route::post('/surveyer/assign/save',array('as'=>'Surveyer Assign Save' , 'desc'=>'entry & edit', 'uses' =>'SurveyerAssignController@Store'));
      #ChangeStatus
      Route::get('/surveyer/assign/change/status/{id}/{status}',array('as'=>'Surveyer Status Change' , 'desc'=>'entry & edit', 'uses' =>'SurveyerAssignController@ChangePublishStatus'));
      #Edit
      Route::get('/surveyer/assign/edit/id-{id}',array('as'=>'Surveyer Assign Edit' , 'desc'=>'entry & edit', 'uses' =>'SurveyerAssignController@Edit'));
      #Update
      Route::post('/surveyer/assign/update/id-{id}',array('as'=>'Surveyer Assign Update' , 'desc'=>'entry & edit', 'uses' =>'SurveyerAssignController@Update'));
      #Delete
      Route::get('/surveyer/assign/delete/id-{id}',array('as'=>'Surveyer Assign Delete' , 'desc'=>'entry & edit', 'uses' =>'SurveyerAssignController@Delete'));





      /*################
      ## Earn Payment Settings
      #################*/

      #getAllContent
      Route::get('/earn/payment/list',array('as'=>'Earn Payment List' , 'desc'=>'entry & edit', 'uses' =>'EarnPaidController@getAllContent'));

      #Create
      Route::get('/earn/payment',array('as'=>'Earn Payment' , 'desc'=>'entry & edit', 'uses' =>'EarnPaidController@Create'));

      #Store
      Route::post('/earn/payment/save',array('as'=>'Earn Payment Save' , 'desc'=>'entry & edit', 'uses' =>'EarnPaidController@Store'));

      #ChangePublishStatus
      Route::get('/earn/payment/change/status/{id}/{status}',array('as'=>'Earn Payment Status Change' , 'desc'=>'entry & edit', 'uses' =>'EarnPaidController@ChangePublishStatus'));

      #Edit
      Route::get('/earn/payment/edit/id-{id}',array('as'=>'Earn Payment Edit' , 'desc'=>'entry & edit', 'uses' =>'EarnPaidController@Edit'));

      #Update
      Route::post('/earn/payment/update/id-{id}',array('as'=>'Earn Payment Update' , 'desc'=>'entry & edit', 'uses' =>'EarnPaidController@Update'));

      #Delete
      Route::get('/earn/payment/delete/id-{id}',array('as'=>'Earn Payment Delete' , 'desc'=>'entry & edit', 'uses' =>'EarnPaidController@Delete'));




      /*################
      ## Question Settings
      #################*/

      #getAllContent
      Route::get('/question/list',array('as'=>'Get All Question Content' , 'desc'=>'entry & Edit', 'uses' =>'QuestionController@getAllContent'));
      #Create
      Route::get('/question/create',array('as'=>'Question Create' , 'desc'=>'entry & edit', 'uses' =>'QuestionController@Create'));
      #Store
      Route::post('/question/save',array('as'=>'Question Save' , 'desc'=>'entry & edit', 'uses' =>'QuestionController@Store'));
      #ChangeStatus
      Route::get('/question/change/status/{id}/{status}',array('as'=>'Question Status Change' , 'desc'=>'entry & edit', 'uses' =>'QuestionController@ChangePublishStatus'));
      #Edit
      Route::get('/question/edit/id-{id}',array('as'=>'Question Edit' , 'desc'=>'entry & edit', 'uses' =>'QuestionController@Edit'));
      #Update
      Route::post('/question/update/id-{id}',array('as'=>'Question Update' , 'desc'=>'entry & edit', 'uses' =>'QuestionController@Update'));
      #Delete
      Route::get('/question/delete/id-{id}',array('as'=>'Question Delete' , 'desc'=>'entry & edit', 'uses' =>'QuestionController@Delete'));


 




 
      /*################
      ## Reports
      #################*/

      /*#Report Cashflow
      Route::get('/reports/cash-flow',array('as'=>'Reports of Cash Flow', 'desc'=>'view & detail', 'uses'=>'ReportController@ReportCahsFlowPage'));

      #Report Cashflow 
      Route::get('/reports/cash-flow/ledger',array('as'=>'Reports of Cash Flow', 'desc'=>'ledger & detail', 'uses'=>'ReportController@ReportCahsFlowLedgerPage'));*/


});

##################### END OF Common Auth #######################################




