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



      Route::get('/login',array('as'=>'LogIn' , 'uses' =>'SystemAuthController@authLogin'));



      Route::get('/hello/pdf',array('as'=>'PDF' , 'uses' =>'AdminController@TestPdf'));
	// Route::get('/login',array('as'=>'LogIn' , 'uses' =>'SystemController@LoginPage'));
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

      #ChangeUserStatus
      Route::get('admin/change/user/status/{user_id}/{status}',array('as'=>'Change User Status' , 'uses' =>'AdminController@ChangeUserStatus'));


      Route::get('/hello',array('as'=>'hello' , 'uses' =>'PortalQuestionController@getAllContent'));




      #PortalCampaign
      Route::get('/participate/registration',array('as'=>'Participate Registration' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@ParticipateRegistration'));

      Route::post('/participate/registration/save',array('as'=>'Registration Confirm' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@RegistrationConfirm'));

      Route::get('/participate/login',array('as'=>'Participate Login' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@ParticipateLogin'));

      Route::post('/participate/login',array('as'=>'Participate Login' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@ParticipatePostLogin'));

      Route::get('/participate/earn',array('as'=>'Participate Earn' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@ParticipateEarn'));

      Route::get('/participate/home',array('as'=>'Home' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@getAllCampaign'));

      Route::get('/portal/participate/list',array('as'=>'Participate List' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@getParticipateCampaignList'));

      Route::get('/portal/participate/campaign/details/{campaign_id}',array('as'=>'Participate Campaign List' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@getParticipateCampaigndetails'));

      // Route::get('/campaign/details',array('as'=>'Campaign Details' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@getCampaignDetails'));

      #Create
      Route::get('/campaign/question/answer/{campaign_id}/{question_position}',array('as'=>'Question Answer Create' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@FirstQuestionAnswer'));

      Route::get('/campaign/all/question/answer/{participate_mobile}/{campaign_id}/{question_position}',array('as'=>'All Question Answer Create' , 'desc'=>'entry & Edit', 'uses' =>'PortalController@QuestionAnswer'));
      
      #Store
      Route::post('/campaign/question/answer/save/{campaign_id}/{question_position}',array('as'=>'Question Answer Save' , 'desc'=>'entry & edit', 'uses' =>'PortalController@Store'));

      Route::post('/campaign/question/answer/save/{participate_mobile}/{campaign_id}/{question_position}',array('as'=>'Question Answer Save' , 'desc'=>'entry & edit', 'uses' =>'PortalController@QuestionAnswerStore'));


/*
#####################
## Admins Module
######################
*/
Route::group(['middleware' => ['admin_auth']], function () {


      Route::get('/admin/profile',array('as'=>'Admin Profile' , 'uses' =>'AdminController@Profile'));
      Route::get('/admin/user/management',array('as'=>'Admin User management' , 'uses' =>'AdminController@UserManagement'));
      Route::post('/admin/user/create',array('as'=>'Admin User create' , 'uses' =>'AdminController@CreateUser'));

      Route::post('admin/profile/update',array('as'=>'Profile Update' , 'uses' =>'AdminController@ProfileUpdate'));
      Route::post('admin/profile/image/update',array('as'=>'Profile Image Update' , 'uses' =>'AdminController@ProfileImageUpdate'));
      Route::post('admin/change/password',array('as'=>'User Change Password' , 'uses' =>'AdminController@UserChangePassword'));


      /*################
      ## Category Settings
      #################*/

      #getAllContent
      Route::get('/category/list',array('as'=>' Category List' , 'desc'=>'entry & Edit', 'uses' =>'CategoryController@getAllContent'));
      #Create
      Route::get('/category/create',array('as'=>'Category Create' , 'desc'=>'entry & edit', 'uses' =>'CategoryController@Create'));
      #Store
      Route::post('/category/save',array('as'=>'Category Save' , 'desc'=>'entry & edit', 'uses' =>'CategoryController@Store'));
      #ChangeStatus
      Route::get('/category/change/status/{id}/{status}',array('as'=>'Category Status Change' , 'desc'=>'entry & edit', 'uses' =>'CategoryController@ChangePublishStatus'));
      #Edit
      Route::get('/category/edit/id-{id}',array('as'=>'Category Edit' , 'desc'=>'entry & edit', 'uses' =>'CategoryController@Edit'));
      #Update
      Route::post('/category/update/id-{id}',array('as'=>'Category Update' , 'desc'=>'entry & edit', 'uses' =>'CategoryController@Update'));
      #Delete
      Route::get('/category/delete/id-{id}',array('as'=>'Category Delete' , 'desc'=>'entry & edit', 'uses' =>'CategoryController@Delete'));




      /*################
      ## Zone Settings
      #################*/

      #getAllContent
      Route::get('/zone/list',array('as'=>' Zone List' , 'desc'=>'entry & Edit', 'uses' =>'ZoneController@getAllContent'));
      #Create
      Route::get('/zone/create',array('as'=>'Zone Create' , 'desc'=>'entry & edit', 'uses' =>'ZoneController@Create'));
      #Store
      Route::post('/zone/save',array('as'=>'Zone Save' , 'desc'=>'entry & edit', 'uses' =>'ZoneController@Store'));
      #ChangeStatus
      Route::get('/zone/change/status/{id}/{status}',array('as'=>'Zone Status Change' , 'desc'=>'entry & edit', 'uses' =>'ZoneController@ChangePublishStatus'));
      #Edit
      Route::get('/zone/edit/id-{id}',array('as'=>'Zone Edit' , 'desc'=>'entry & edit', 'uses' =>'ZoneController@Edit'));
      #Update
      Route::post('/zone/update/id-{id}',array('as'=>'Zone Update' , 'desc'=>'entry & edit', 'uses' =>'ZoneController@Update'));
      #Delete
      Route::get('/zone/delete/id-{id}',array('as'=>'Zone Delete' , 'desc'=>'entry & edit', 'uses' =>'ZoneController@Delete'));




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

      #CampaignPaymentDelete
      Route::get('/campaign/payment/delete/id-{id}',array('as'=>'Campaign Payment Delete' , 'desc'=>'entry & edit', 'uses' =>'PaymentController@CampaignPaymentDelete'));



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

      #SuccessConfirm
      Route::get('/surveyer/success/confirm/{id}/{status}',array('as'=>'Surveyer Success Confirme' , 'desc'=>'entry & edit', 'uses' =>'SurveyerAssignController@SuccessConfirm'));





      /*################
      ## Earn Payment Settings
      #################*/

      #getAllContent
      Route::get('/earn/payment/list',array('as'=>'Earn Payment List' , 'desc'=>'entry & edit', 'uses' =>'EarnPaidController@getAllContent'));

      #Create
      Route::get('/earn/payment',array('as'=>'Earn Payment' , 'desc'=>'entry & edit', 'uses' =>'EarnPaidController@Create'));

      #AjaxTypeSelect
      Route::get('/ajax/payment/user/{user_type}',array('as'=>'Ajax Payment User Type' , 'desc'=>'entry & edit', 'uses' =>'EarnPaidController@AjaxPaymentUserType'));

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


 

      /*#######################
      ## Question Answer Settings
      #########################*/

      #getAllCampaign
      Route::get('/participate/campaign/list',array('as'=>'Active Campaign List' , 'desc'=>'entry & Edit', 'uses' =>'QuestionAnswerController@getAllCampaign'));

      #getAllContent
      Route::get('/question/answer/list',array('as'=>'Question Answer List' , 'desc'=>'entry & Edit', 'uses' =>'QuestionAnswerController@getAllContent'));

      #Create
      Route::get('/question/answer/{surveyer_id}/{campaign_id}/{question_position}',array('as'=>'Question Answer Create' , 'desc'=>'entry & Edit', 'uses' =>'QuestionAnswerController@FirstQuestionAnswer'));

      Route::get('/all/question/answer/{participate_mobile}/{surveyer_id}/{campaign_id}/{question_position}',array('as'=>'All Question Answer Create' , 'desc'=>'entry & Edit', 'uses' =>'QuestionAnswerController@QuestionAnswer'));
      
      #Store
      Route::post('/question/answer/save/{surveyer_id}/{campaign_id}/{question_position}',array('as'=>'Question Answer Save' , 'desc'=>'entry & edit', 'uses' =>'QuestionAnswerController@Store'));

      Route::post('/question/answer/save/{participate_mobile}/{surveyer_id}/{campaign_id}/{question_position}',array('as'=>'Question Answer Save' , 'desc'=>'entry & edit', 'uses' =>'QuestionAnswerController@QuestionAnswerStore'));

      #ChangeStatus
      Route::get('/question/answer/change/status/{id}/{status}',array('as'=>'Question Answer Status Change' , 'desc'=>'entry & edit', 'uses' =>'QuestionAnswerController@ChangePublishStatus'));

      #ChangeValidateStatus
      Route::get('/question/answer/validate/status/{id}/{status}',array('as'=>'Question Answer Validate Status' , 'desc'=>'entry & edit', 'uses' =>'QuestionAnswerController@ChangeValidateStatus'));

      #Edit
      Route::get('/question/answer/edit/id-{id}',array('as'=>'Question Answer Edit' , 'desc'=>'entry & edit', 'uses' =>'QuestionAnswerController@Edit'));
      #Update
      Route::post('/question/answer/update/id-{id}',array('as'=>'Question Answer Update' , 'desc'=>'entry & edit', 'uses' =>'QuestionAnswerController@Update'));
      #Delete
      Route::get('/question/answer/delete/id-{id}',array('as'=>'Question Answer Delete' , 'desc'=>'entry & edit', 'uses' =>'QuestionAnswerController@Delete'));

      #Campaign Participate Countdown
      Route::get('/admin/campaign/participate/countdown',array('as'=>'Campaign Survey Countdown' , 'desc'=>'entry & edit', 'uses' =>'QuestionAnswerController@getAllContentCountdown'));

      #Campaign Answer Question
      Route::get('/admin/campaign/participate/question-{question_id}',array('as'=>'Admin Campaign Participate Question' , 'desc'=>'entry & edit', 'uses' =>'QuestionAnswerController@getAllSingleQuestionAnswer'));




      #ParticipateQuestionAnswer
      Route::get('/participate/question/answer/{participate_mobile}/{campaign_id}/{question_position}',array('as'=>'Participate Question Answer' , 'desc'=>'entry & Edit', 'uses' =>'QuestionAnswerController@ParticipateQuestionAnswer'));
      
      #ParticipateQuestionAnswerStore
      Route::post('/participate/question/answer/save/{participate_mobile}/{campaign_id}',array('as'=>'Participate Question Answer Store' , 'desc'=>'entry & edit', 'uses' =>'QuestionAnswerController@ParticipateQuestionAnswerStore'));



});



/*
#####################
## Requester Module
######################
*/
Route::group(['middleware' => ['requester_auth']], function () {

      Route::get('/requester/profile',array('as'=>'Requester Profile' , 'uses' =>'AdminRequesterController@Profile'));

      Route::post('requester/profile/update',array('as'=>'Profile Update' , 'uses' =>'AdminRequesterController@ProfileUpdate'));

      Route::post('requester/profile/image/update',array('as'=>'Profile Image Update' , 'uses' =>'AdminRequesterController@ProfileImageUpdate'));

      Route::post('requester/change/password',array('as'=>'User Change Password' , 'uses' =>'AdminRequesterController@UserChangePassword'));


      /*################
      ## Campaign Settings
      #################*/

      #getAllContent
      Route::get('/requester/campaign/list',array('as'=>'Get All Campaign Content' , 'desc'=>'entry & Edit', 'uses' =>'AdminRequesterController@getAllContent'));
      #Create
      Route::get('/requester/campaign/create',array('as'=>'Campaign Create' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@Create'));
      #Store
      Route::post('/requester/campaign/save',array('as'=>'Campaign Save' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@Store'));

      #Campaign Participate Countdown
      Route::get('/campaign/participate/countdown',array('as'=>'Campaign Participate Countdown' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@getAllContentCountdown'));

      #Campaign Answer Question
      Route::get('/campaign/participate/question-{question_id}',array('as'=>'Campaign Participate Question' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@getAllSingleQuestionAnswer'));

      #Requester Payment List
      Route::get('/requester/payment/list',array('as'=>'Requester Payment List' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@RequesterPaymentList'));

      #ChangeStatus
      Route::get('/requester/campaign/change/status/{id}/{status}',array('as'=>'Campaign Status Change' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@ChangePublishStatus'));
      #Edit
      Route::get('/requester/campaign/edit/id-{id}',array('as'=>'Campaign Edit' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@Edit'));
      #Update
      Route::post('/requester/campaign/update/id-{id}',array('as'=>'Campaign Update' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@Update'));
      #Delete
      Route::get('/requester/campaign/delete/id-{id}',array('as'=>'Campaign Delete' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@Delete'));



      /*################
      ## Question Settings
      #################*/

      #getAllContent
      Route::get('/requester/question/list',array('as'=>'Get All Question Content' , 'desc'=>'entry & Edit', 'uses' =>'AdminRequesterController@getAllQuestion'));
      #Create
      Route::get('/requester/question/create',array('as'=>'Question Create' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@QuestionCreate'));
      #Store
      Route::post('/requester/question/save',array('as'=>'Question Save' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@QuestionStore'));
      #ChangeStatus
      Route::get('/requester/question/change/status/{id}/{status}',array('as'=>'Question Status Change' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@ChangeQuestionPublishStatus'));
      #Edit
      Route::get('/requester/question/edit/id-{id}',array('as'=>'Question Edit' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@QuestionEdit'));
      #Update
      Route::post('/requester/question/update/id-{id}',array('as'=>'Question Update' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@QuestionUpdate'));
      #Delete
      Route::get('/requester/question/delete/id-{id}',array('as'=>'Question Delete' , 'desc'=>'entry & edit', 'uses' =>'AdminRequesterController@QuestionDelete'));


});
 

/*
#####################
## Requester Module
######################
*/
Route::group(['middleware' => ['surveyer_auth']], function () {


      Route::get('/surveyer/profile',array('as'=>'Requester Profile' , 'uses' =>'AdminSurveyerController@Profile'));

      Route::post('surveyer/profile/update',array('as'=>'Profile Update' , 'uses' =>'AdminSurveyerController@ProfileUpdate'));

      Route::post('surveyer/profile/image/update',array('as'=>'Profile Image Update' , 'uses' =>'AdminSurveyerController@ProfileImageUpdate'));

      Route::post('surveyer/change/password',array('as'=>'User Change Password' , 'uses' =>'AdminSurveyerController@UserChangePassword'));


      /*#######################
      ## Question Answer Settings
      #########################*/

      #getAllCampaign
      Route::get('/surveyer/participate/campaign/list',array('as'=>'Active Campaign List' , 'desc'=>'entry & Edit', 'uses' =>'AdminSurveyerController@getAllCampaign'));

      #Campaign Participate Countdown
      Route::get('/surveyer/participate/countdown',array('as'=>'Surveyer Participate Countdown' , 'desc'=>'entry & edit', 'uses' =>'AdminSurveyerController@getAllContentCountdown'));

      #Campaign Answer Question
      Route::get('/surveyer/participate/question-{question_id}',array('as'=>'Surveyer Participate Question' , 'desc'=>'entry & edit', 'uses' =>'AdminSurveyerController@getAllSingleQuestionAnswer'));

      #Surveyer Payment List
      Route::get('/surveyer/payment/list',array('as'=>'Surveyer Payment List' , 'desc'=>'entry & edit', 'uses' =>'AdminSurveyerController@SurveyerPaymentList'));






      #getAllContent
      Route::get('/surveyer/question/answer/list',array('as'=>'Question Answer List' , 'desc'=>'entry & Edit', 'uses' =>'AdminSurveyerController@getAllContent'));

      #Create
      Route::get('/surveyer/question/answer/{surveyer_id}/{campaign_id}/{question_position}',array('as'=>'Question Answer Create' , 'desc'=>'entry & Edit', 'uses' =>'AdminSurveyerController@FirstQuestionAnswer'));

      Route::get('/surveyer/all/question/answer/{participate_mobile}/{surveyer_id}/{campaign_id}/{question_position}',array('as'=>'All Question Answer Create' , 'desc'=>'entry & Edit', 'uses' =>'AdminSurveyerController@QuestionAnswer'));
      
      #Store
      Route::post('/surveyer/question/answer/save/{surveyer_id}/{campaign_id}/{question_position}',array('as'=>'Question Answer Save' , 'desc'=>'entry & edit', 'uses' =>'AdminSurveyerController@Store'));

      Route::post('/surveyer/question/answer/save/{participate_mobile}/{surveyer_id}/{campaign_id}/{question_position}',array('as'=>'Question Answer Save' , 'desc'=>'entry & edit', 'uses' =>'AdminSurveyerController@QuestionAnswerStore'));

      #ChangeStatus
      Route::get('/surveyer/question/answer/change/status/{id}/{status}',array('as'=>'Question Answer Status Change' , 'desc'=>'entry & edit', 'uses' =>'AdminSurveyerController@ChangePublishStatus'));
      #Edit
      Route::get('/surveyer/question/answer/edit/id-{id}',array('as'=>'Question Answer Edit' , 'desc'=>'entry & edit', 'uses' =>'AdminSurveyerController@Edit'));
      #Update
      Route::post('/surveyer/question/answer/update/id-{id}',array('as'=>'Question Answer Update' , 'desc'=>'entry & edit', 'uses' =>'AdminSurveyerController@Update'));
      #Delete
      Route::get('/surveyer/question/answer/delete/id-{id}',array('as'=>'Question Answer Delete' , 'desc'=>'entry & edit', 'uses' =>'AdminSurveyerController@Delete'));


 


});


##################### END OF Common Auth #######################################




