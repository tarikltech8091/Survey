<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\System;

class ApiController extends Controller
{
    public function __construct(){

        $this->page_title = \Request::route()->getName();
        \App\System::AccessLogWrite();
    }


    /********************************************
    ## GetAccessToken
     *********************************************/
    /*public function GetAccessToken(Request $request){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo[] =""; 

            $imei_no = $request->input('imei_no');
            $app_key = $request->input('app_key');


            if(empty($app_key))
                throw new \Exception("User APP Key is Required.");

            $data['imei_no'] = $imei_no;
            $data['app_key'] = $app_key;

            // $data['access_token'] = $app_key;
            $data['client_ip'] = $accessinfo['client_ip'];
            $data['access_browser'] = $accessinfo['access_browser'];
            $data['access_city'] = $accessinfo['access_city'];
            $data['access_division'] = $accessinfo['access_division'];
            $data['access_country'] = $accessinfo['access_country'];
            $data['referenceCode'] = $now;
            $data['token_status'] = '1';


            if(!empty($request->input('imei_no')))
                $data['imei_no'] = $request->input('imei_no');


            $user_info = \App\AppToken::updateOrCreate(
                ['app_key' =>$data['app_key']],
                ['imei_no' =>$data['imei_no']],
                $data
            );

            if($user_info->wasRecentlyCreated)
                $success_message ="App install Successfully";
            else $success_message ="Already installed";

            #ForToken
            $response["success"]= [
                "statusCode"=> 200,
                "successMessage"=> $success_message,
                "serverReferenceCode"=>$now
            ];


            if(!$token = \JWTAuth::attempt($data))

            // if(!$token = auth('api')->attempt($data))

                throw new \Exception("Something Wrong In Token");

            $response["access_token"]= $token;

            // \App\System::APILogWrite(\Request::all(),$response);
            return \Response::json($response);


        }catch(\Exception $e){
            $response["errors"]= [
                "statusCode"=> 501,
                "errorMessage"=> $e->getMessage(),
                "serverReferenceCode"=> $now,
            ];

            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\System::APILogWrite(\Request::all(),$response);
            return \Response::json($response);
        }
    }*/


    /********************************************
    ## GetAccessToken
     *********************************************/
    public function GetAccessToken(Request $request){

        $now=date('Y-m-d H:i:s');

        try{

            $app_key = $request->input('user_app_key');

            if(empty($app_key))
                throw new \Exception("User APP Key is Required.");

            $user_mobile = substr($request->input('user_mobile'), -11);

            $mobile_num_count=strlen($user_mobile);

            if(is_numeric($user_mobile) && $mobile_num_count == 11){

                if(!empty($request->input('user_mobile'))){

                    $data['name'] = 'Unknown';
                    $data['name_slug'] = 'unknown';
                    $data['user_type'] = 'app';
                    $data['user_role'] = 'app';
                    $data['user_mobile'] = substr($request->input('user_mobile'), -11);
                    $data['user_app_key'] = !empty($request->input('user_app_key'))?$request->input('user_app_key'):'anonymous';
                    $data['user_imei_info'] = !empty($request->input('user_imei_info'))?$request->input('user_imei_info'):'anonymous';;
                    $data['user_profile_image'] = '';
                    $data['email'] = !empty($request->input('email'))?$request->input('email'):'unknown@unknown.com';
                    $data['password']=\Hash::make('1234');

                }else{

                    $response["errors"]= [
                        "statusCode"=> 403,
                        "successMessage"=> 'Mobile number is required.',
                        "serverReferenceCode"=>$now
                    ];

                    \App\System::APILogWrite(\Request::all(),$response);
                    return \Response::json($response);

                }

                $data['login_status'] = 0;
                $data['status'] = 'active';

                    
                /*$user_info = \App\User::updateOrCreate(
                    ['user_app_key' =>$data['user_app_key']],
                    ['user_mobile' =>$data['user_mobile']],
                    $data
                );*/


                $current_user =\DB::table('users')->where('user_mobile', $user_mobile)->first();

                if(empty($current_user)){

                    $user_info =\DB::table('users')->insert($data);

                    if($user_info)

                        $success_message ="Registration Successfully Completed";

                    else $success_message ="Already Registered";

                    #ForToken
                    $response["iTunes"]= 1;
                    $data['password']='1234';

                    $response["success"]= [
                        "statusCode"=> 200,
                        "successMessage"=> $success_message,
                        "serverReferenceCode"=>$now
                    ];

                }else{


                    $update_data['user_app_key'] = !empty($request->input('user_app_key'))?$request->input('user_app_key'):'anonymous';
                    $update_data['user_imei_info'] = !empty($request->input('user_imei_info'))?$request->input('user_imei_info'):'anonymous';;
                    $update_data['user_profile_image'] = '';


                    $user_info =\DB::table('users')->where('user_mobile', $user_mobile)->update($update_data);

                    $response["iTunes"]= 1;
                    $data['password']='1234';
                    $response["success"]= [
                            "statusCode"=> 200,
                            "errorMessage"=> "Already Register User",
                            "serverReferenceCode"=> $now
                        ];

                }


                if(!$token = \JWTAuth::attempt($data))
                // if(!$token = auth('api')->attempt($data))
                    throw new \Exception("Something Wrong In Token");

                // $response["access_token"]= $token;
                $response["token"]= $token;

                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);

            }else{

                $response["errors"]= [
                    "statusCode"=> 403,
                    "successMessage"=> 'Mobile number is to be 11 digit.',
                    "serverReferenceCode"=>$now
                ];

                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);

            }



        }catch(\Exception $e){
            $response["errors"]= [
                "statusCode"=> 501,
                "errorMessage"=> $e->getMessage(),
                "serverReferenceCode"=> $now,
            ];

            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\System::APILogWrite(\Request::all(),$response);
            return \Response::json($response);
        }
    }

    

    /********************************************
    ## GetMSISDN
     *********************************************/

    public function GetMSISDN(){

        if(isset($_SERVER['USER_IDENTITY_FORWARD_MSISDN']))
        {
            $mobile_number = trim($_SERVER['HTTP_X_UP_CALLING_LINE_ID']);
        }
        else if(isset($_SERVER['HTTP_MSISDN']))
        {
            $mobile_number = trim($_SERVER['HTTP_MSISDN']);
        }
        else if(isset($_SERVER['HTTP_X_FH_MSISDN']))
        {
            $mobile_number = trim($_SERVER['HTTP_X_FH_MSISDN']);
        }
        else if(isset($_SERVER['HTTP_X_HTS_CLID']))
        {
            $mobile_number = trim($_SERVER['HTTP_X_HTS_CLID']);
        }
        else if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']))
        {
            $mobile_number = trim($_SERVER['HTTP_X_UP_CALLING_LINE_ID']);
        }
        else if(isset($_SERVER['HTTP-ALL-RAW']))
        {
            $mobile_number = trim($_SERVER['HTTP-ALL-RAW']);
        }
        else if(isset($_SERVER['HTTP-HOST']))
        {
            $mobile_number = trim($_SERVER['HTTP-HOST']);
        }
        else if(isset($_SERVER['x-msisdn']))
        {
            $mobile_number = trim($_SERVER['x-msisdn']);
        }
        else if(isset($_SERVER['HTTP-x-msisdn']))
        {
            $mobile_number = trim($_SERVER['HTTP-x-msisdn']);
        }
        else if(isset($_SERVER['x-h3g-msisdn']))
        {
            $mobile_number = trim($_SERVER['x-h3g-msisdn']);
        }
        else if(isset($_SERVER['HTTP-x-h3g-msisdn']))
        {
            $mobile_number = trim($_SERVER['HTTP-x-h3g-msisdn']);
        }
        else if(isset($_SERVER['HTTP-X-MSISDN-Alias']))
        {
            $mobile_number = trim($_SERVER['HTTP-X-MSISDN-Alias']);
        }
        else if(isset($_SERVER['X-MSISDN-Alias']))
        {
            $mobile_number = trim($_SERVER['X-MSISDN-Alias']);
        }
        else if(isset($_SERVER['HTTP-x-h3g-msisdn']))
        {
            $mobile_number = trim($_SERVER['HTTP-x-h3g-msisdn']);
        }
        else if(isset($_SERVER['HTTP-msisdn']))
        {
            $mobile_number = trim($_SERVER['HTTP-msisdn']);
        }
        else if(isset($_SERVER['msisdn']))
        {
            $mobile_number = trim($_SERVER['msisdn']);
        }
        else if(isset($_SERVER['MSISDN']))
        {
            $mobile_number = trim($_SERVER['MSISDN']);
        }
        else if(isset($_SERVER['X-WAP-PROFILE']))
        {
            $mobile_number = trim($_SERVER['X-WAP-PROFILE']);
        }

        else if(isset($_SERVER['X-UP-CALLING-LINE-ID ']))
        {
            $mobile_number = trim($_SERVER['X-UP-CALLING-LINE-ID ']);
        }
        else if(isset($_SERVER['X-H3G-MSISDN']))
        {
            $mobile_number = trim($_SERVER['X-H3G-MSISDN']);
        }
        else if(isset($_SERVER['X-FH-MSISDN ']))
        {
            $mobile_number = trim($_SERVER['X-FH-MSISDN ']);
        }
        else if(isset($_SERVER['X-MSP-MSISDN']))
        {
            $mobile_number = trim($_SERVER['X-MSP-MSISDN']);
        }
        else if(isset($_SERVER['X-INTERNET-MSISDN']))
        {
            $mobile_number = trim($_SERVER['X-INTERNET-MSISDN']);
        }
        else if(isset($_SERVER['X_MSISDN']))
        {
            $mobile_number = trim($_SERVER['X_MSISDN']);
        }
        else if(isset($_SERVER['HTTP_X_MSISDN']))
        {
            $mobile_number = trim($_SERVER['HTTP_X_MSISDN']);
        }

        if (isset($mobile_number)) {

            $response =\App\Subscription::MnpIPBlockCheck($mobile_number);

        } else {
            // return response()->json(['msisdn'=>'NO_MSISDN','operator'=>'blink']);
            $response = ['msisdn'=>'NO_MSISDN','operator'=>'blink'];
        }

        \App\System::APILogWrite(\Request::all(),$response);
        return \Response::json($response);

    }

    

    /********************************************
    ## participateRegistration
    *********************************************/

    public function participateRegistration(){
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $participate_mobile=$userinfo['participate_mobile'];

                if(is_numeric($participate_mobile) && strlen($participate_mobile)==11){


                    $success = \DB::transaction(function () use($userinfo) {


                        $participate_profile_image='';
                        $image_type='participate';

                        $participate_name=$userinfo['participate_name'];
                        $participate_email=$userinfo['participate_email'];
                        $slug=explode(' ', strtolower($userinfo['participate_name']));
                        $participate_name_slug=implode('-', $slug);

                        /*if($request->file('participate_profile_image')!=null){

                            #ImageUpload
                            $image_wide = $request->file('participate_profile_image');
                            $img_location_wide=$image_wide->getRealPath();
                            $img_ext_wide=$image_wide->getClientOriginalExtension();
                            $participate_profile_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$participate_name);

                            $participate_profile_image="";

                        }else{*/
                            $participate_profile_image="";
                        // }


                        $participate_registration_confirm=array(
                            'participate_name' => $userinfo['participate_name'],
                            'participate_name_slug' => $participate_name_slug,
                            'participate_email' => $userinfo['participate_email'],
                            'participate_mobile' =>$userinfo['participate_mobile'],
                            'status' => 1,
                            'participate_age' => $userinfo['participate_age'],
                            'participate_join_date' =>$userinfo['participate_join_date'],
                            'participate_district' => $userinfo['participate_district'],
                            'participate_post_code' => $userinfo['participate_post_code'],
                            'participate_address' =>$userinfo['participate_address'],
                            'participate_nid' => $userinfo['participate_nid'],
                            'participate_gender' => $userinfo['participate_gender'],
                            'participate_religion' => $userinfo['participate_religion'],
                            'participate_occupation' => $userinfo['participate_occupation'],
                            'participate_zone' => $userinfo['participate_zone'],
                            'agreed_user' =>'0',
                            'participate_profile_image' => $participate_profile_image,
                            'created_at' => $now,
                            'updated_at' => $now,
                        );




                        $participate_registration_update=array(
                            'participate_name' => $userinfo['participate_name'],
                            'participate_name_slug' => $participate_name_slug,
                            'participate_email' => $userinfo['participate_email'],
                            'participate_mobile' =>$userinfo['participate_mobile'],
                            'participate_age' => $userinfo['participate_age'],
                            'participate_join_date' =>$userinfo['participate_join_date'],
                            'participate_district' => $userinfo['participate_district'],
                            'participate_post_code' => $userinfo['participate_post_code'],
                            'participate_address' =>$userinfo['participate_address'],
                            'participate_nid' => $userinfo['participate_nid'],
                            'participate_gender' => $userinfo['participate_gender'],
                            'participate_religion' => $userinfo['participate_religion'],
                            'participate_occupation' => $userinfo['participate_occupation'],
                            'participate_zone' => $userinfo['participate_zone'],
                            'participate_profile_image' => $participate_profile_image,
                            'updated_at' => $now,
                        );


                        $participate_info=\DB::table('participate_tbl')->where('participate_mobile',$userinfo['participate_mobile'])->first();

                        if(empty($participate_info)){

                            $participate_registration_info=\DB::table('participate_tbl')->insertGetId($participate_registration_confirm);

                        }else{

                            $participate_registration_info=\DB::table('participate_tbl')->where('participate_mobile',$userinfo['participate_mobile'])->update($participate_registration_confirm);

                        }

                        // \App\System::EventLogWrite('insert,participate_tbl',json_encode($participate_registration_confirm));



                        $login_data['name']=ucwords($userinfo['participate_name']);
                        $login_data['name_slug']=$participate_name_slug;
                        $login_data['user_type']='participate';
                        $login_data['user_role']='participate';
                        $login_data['email']=$userinfo['participate_email'];
                        $login_data['user_mobile']=$userinfo['participate_mobile'];
                        $login_data['user_profile_image']=$participate_profile_image;
                        $login_data['login_status']='0';
                        $login_data['status']='active';
                        $login_data['updated_at']=$now;

                        // $login_data_insert=\App\User::insertGetId($login_data);

                        $login_data_insert = \App\User::updateOrCreate(
                            [
                                'user_mobile' => $login_data['user_mobile'],
                            ],
                            $login_data
                        );



                        if(!$participate_registration_info || !$login_data_insert){
                            $error=1;
                        }


                        if(!isset($error)){

                            // \App\System::EventLogWrite('insert,participate_tbl',json_encode($participate_registration_confirm));
                            \DB::commit();

                            
                        }else{
                            \DB::rollback();
                            throw new Exception("Error Processing Request", 1);
                        }



                    });




                        $response["success"]= [
                            "statusCode"=> 200,
                            "successMessage"=> "Registration Successfully.",
                            "serverReferenceCode"=>$now
                        ];

                        $response["participateinfo"]=$participate_registration_info;


                        \App\Api::ResponseLogWrite('Registration Successfully',json_encode($response));
                        return \Response::json($response);


                }else{

                    $response["errors"]= [
                            "statusCode"=> 403,
                            "errorMessage"=> "Invalid Mobile Number.",
                            "serverReferenceCode"=> $now
                        ];

                    \App\Api::ResponseLogWrite('Invalid Mobile Number.',json_encode($response));

                    return \Response::json($response);
                } 


            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "IMEI Number or Access Token is invalid",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('IMEI Number or Access Token is invalid',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## SurveyerOrRequesterLogin
    *********************************************/
    public function SurveyerOrRequesterLogin(){

        $now=date('Y-m-d H:i:s');
        try{

            $accessinfo = \Request::input('accessinfo');
            $logininfo = \Request::input('logininfo');
            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($logininfo)){

                    $user_mobile = $logininfo['user_mobile'];
                    $password = $logininfo['password'];
                    $user_role = $logininfo['user_role'];

                    $surveyer_info=\DB::table('users')->where('user_mobile',$user_mobile)->where('user_role', $user_role)->where('status','1')->first();

                if(!empty($surveyer_info)){


                    $credentials = [
                        'user_mobile' =>$user_mobile,
                        'password'=>$password,
                        'status'=>'active',
                    ];


                    if(\Auth::attempt($credentials)){


                        $response["success"]= [
                            "statusCode"=> 200,
                            "successMessage"=> "Successfully Login.",
                            "serverReferenceCode"=>$now
                        ];

                        $response["logininfo"]= $surveyer_info;

                        $requestlog_update_data=[
                            "request_response"=>json_encode($response),
                            "updated_at"=>$now,
                        ];
                        $user_update_data=[
                            "updated_at"=>$now,
                        ];
                                                
                        $client_registration_update=\DB::table('users')->where('id', $surveyer_info->id)->update($user_update_data);

                        \App\Api::ResponseLogWrite('Successfully Login.',json_encode($response));

                        return \Response::json($response);


                    }else{

                        $response["errors"]= [
                            "statusCode"=> 403,
                            "errorMessage"=> "Incorrect combinations. Please try again.",
                            "serverReferenceCode"=> $now
                        ];

                        \App\Api::ResponseLogWrite('Incorrect combinations.Please try again.',json_encode($response));

                        return \Response::json($response);
                    }

                }else{
                    $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid user or block user.",
                        "serverReferenceCode"=> $now
                    ];

                    \App\Api::ResponseLogWrite('Invalid user.',json_encode($response));

                    return \Response::json($response);
                }

            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Please provide user mobile and password.",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('IMEI Number or Access Token is invalid',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];

            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }

     /********************************************
     ## ProfileUpdate 
     *********************************************/


    public function ProfileUpdate(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            if(!empty($userinfo)){

                $user_id=$accessinfo['user_id'];
                $user_info=\DB::table('users')->where('id',$user_id)->first();

                if(!empty($userinfo['name'])){
                   $name=$userinfo['name'];
                   $name_slug = explode(' ', strtolower($name));
                   $name_slug = implode('_', $name_slug);
                }else{
                    $name=$user_info->name;
                    $name_slug=$user_info->name_slug;
                }

                if(!empty($userinfo['email'])){
                   $email=$userinfo['email'];

                }else{
                    $email=$user_info->email;
                }

                $user_image='';

                $users_update_data=[
                                "name"=>$name,
                                "name_slug"=>$name_slug,
                                "user_profile_image"=>$user_image,
                                "email"=>$email,
                                "updated_at"=>$now,
                            ];

                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Successfully updated",
                    "serverReferenceCode"=>$now
                ];


                $requestlog_update_data=[
                    "request_response"=>json_encode($response),
                    "updated_at"=>$now,
                ];
                $user_update_info=\DB::table('users')->where('id',$accessinfo['user_id'])->update($users_update_data);

                $update_user_info=\DB::table('users')->where('id',$user_id)->first();

                $response["user_info"]=$update_user_info;

                \App\System::EventLogWrite('update,users',json_encode($users_update_data));
                \App\Api::ResponseLogWrite('insert,users',json_encode($response));
                return \Response::json($response);

            }else{
                 $response["errors"]= [
                    "statusCode"=> 403,
                    "errorMessage"=> "IMEI Number or Access Token is invalid",
                    "serverReferenceCode"=> $now
                ];

                \App\Api::ResponseLogWrite('IMEI Number or Access Token is invalid',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

             $response["errors"]= [
                "statusCode"=> 501,
                "errorMessage"=>  $e->getMessage(),
                "serverReferenceCode"=> $now,
            ];

            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }

    }


    /********************************************
    ## getParticipateInfo
    *********************************************/

    public function getParticipateInfo(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $participate_mobile=$userinfo['participate_mobile'];

                $participate_info=\DB::table('participate_tbl')
                ->where('participate_mobile', $participate_mobile)
                ->first();

                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Participate Info Successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["participateinfo"]=$participate_info;

                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User Info",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## getCampaignInfo
    *********************************************/

    public function getCampaignInfo(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $participate_mobile=$userinfo['participate_mobile'];

                $campaign_info= \App\Campaign::where('campaign_status',1)->orderBy('id','DESC')->get();

                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Campaign Successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["campaign_info"]=$campaign_info;


                \App\Api::ResponseLogWrite('Get Campaign Successfully',json_encode($response));
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User Info",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }



    /********************************************
    ## getCampaignParticipateInfo
    *********************************************/

    public function getCampaignParticipateInfo(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $participate_mobile=$userinfo['participate_mobile'];

                $all_content= \App\CampaignParticipate::where('campaign_participate_mobile', $participate_mobile)
                ->join('campaign_tbl', 'campaign_tbl.id', '=', 'campaign_participate_tbl.participate_campaign_id')
                ->select('campaign_tbl.id AS campaign_id', 'campaign_tbl.*', 'campaign_participate_tbl.*')
                ->orderBy('id','DESC')->get();


                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Campaign Participate Successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["campaign_participate_info"]=$all_content;


                \App\Api::ResponseLogWrite('Get Campaign Participate Successfully',json_encode($response));
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User Info",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## getQuestionAnswerInfo
    *********************************************/

    public function getQuestionAnswerInfo(){
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $campaign_id=$campaigninfo['campaign_id'];                
                $participate_mobile=$userinfo['participate_mobile'];                

                $campaign_info= \App\Campaign::where('id', $campaign_id)->first();
                $all_content= \App\QuestionAnswer::where('answer_campaign_id', $campaign_id)->where('answer_participate_mobile', $participate_mobile)->orderBy('id','ASC')->get();

                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get question answer info successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["campaign_info"]=$campaign_info;
                $response["question_answer_info"]=$all_content;


                \App\Api::ResponseLogWrite('Get question answer info successfully',json_encode($response));
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User Info",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }




    /********************************************
    ## getCampaignDetails
    *********************************************/

    public function getCampaignDetails(){
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $participate_mobile=$userinfo['participate_mobile'];                

                $all_content= \App\Campaign::where('campaign_status',1)->orderBy('id','DESC')->get();
                $all_zone=\App\Zone::where('zone_status',1)->get();
                $all_district=\App\Common::AllDistrict();


                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get campaign details info successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["campaign_info"]=$all_content;
                $response["zone_info"]=$all_zone;
                $response["district_info"]=$all_district;


                \App\Api::ResponseLogWrite('Get campaign details info successfully',json_encode($response));
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User Info",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }




    /********************************************
    ## getParticipateQuestionInfo
    *********************************************/

    public function getParticipateQuestionInfo(){
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $campaign_id=$campaigninfo['campaign_id']; 

                $question_position=$campaigninfo['question_position'];

                $participate_mobile=$userinfo['participate_mobile'];                

                $response['select_campaign'] = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();

                $response['select_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();

                $response['all_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();

                $response['total_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->select(DB::raw('count(*) as user_count'))->count();

                $response['all_district']=\App\Common::AllDistrict();
                $response['all_zone']=\App\Zone::where('zone_status',1)->get();

                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get question info successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["campaign_info"]=$campaign_info;
                $response["question_answer_info"]=$all_content;


                \App\Api::ResponseLogWrite('Get question info successfully',json_encode($response));
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User Info",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }




    /********************************************
    ## participateQuestionAnswerStore
    *********************************************/

    public function participateQuestionAnswerStore(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');
            $questionanswerinfo = \Request::input('questionanswerinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo) &&  !empty($campaigninfo) &&  !empty($questionanswerinfo)){

                $answer_campaign_id=$campaigninfo['campaign_id'];

                $answer_question_position=$questionanswerinfo['question_position'];

                $question_next_position = $answer_question_position + 1;

                $campaign_participate_mobile=$userinfo['participate_mobile'];


                $next_question = \DB::table('question_tbl')->where('question_campaign_id',$answer_campaign_id)->where('question_position',$question_next_position)->where('question_status','1')->orderby('id','desc')->first();

                $total_question = \DB::table('question_tbl')->where('question_campaign_id',$answer_campaign_id)->where('question_status','1')->select(DB::raw('count(*) as user_count'))->get();



                $success = \DB::transaction(function () use($request, $campaign_participate_mobile, $answer_question_position, $question_next_position, $next_question, $total_question, $answer_campaign_id) {


                    $now=date('Y-m-d H:i:s');

                    $campaign_id = $answer_campaign_id;
                    $question_position = $answer_question_position;
                    $question_next_position = $question_position + 1;
                    $participate_mobile=$campaign_participate_mobile;


                    $select_participate = \DB::table('participate_tbl')->where('participate_mobile',$campaign_participate_mobile)->first();

                    $select_campaign = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();
                    $select_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();
                    $question_id = $select_question->id;

                    $all_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();


                    if(isset($select_question) && (($select_question->question_position) == 1)){

                        $question_id = $select_question->id;

                        $campaign_participate_data['participate_campaign_id']=$campaign_id;
                        $campaign_participate_data['participate_campaign_name']=$select_campaign->campaign_name;
                        $campaign_participate_data['campaign_participate_mobile']=$campaign_participate_mobile;
                        $campaign_participate_data['campaign_participate_occupation']=$select_participate->participate_occupation;
                        $campaign_participate_data['campaign_participate_age']=$select_participate->participate_age;
                        $campaign_participate_data['campaign_participate_district']=$select_participate->participate_district;
                        $campaign_participate_data['campaign_participate_post_code']=$select_participate->participate_post_code;
                        $campaign_participate_data['campaign_participate_zone']=$select_participate->participate_zone;
                        $campaign_participate_data['campaign_participate_address']=$select_participate->participate_address;
                        $campaign_participate_data['participate_prize_amount']='';
                        $campaign_participate_data['campaign_participate_status']=1;
                        $campaign_participate_data['updated_at']=$now;


                        $campaign_participate_info = \DB::table('campaign_participate_tbl')->where('participate_campaign_id',$campaign_id)->where('campaign_participate_mobile',$campaign_participate_mobile)->first();

                        if(!empty($campaign_participate_info)){

                            $campaign_participate_insertOrUpdate=\DB::table('campaign_participate_tbl')->where('id',$campaign_participate_info->id)->update($campaign_participate_data);

                        }else{

                            $campaign_participate_insertOrUpdate=\DB::table('campaign_participate_tbl')->insert($campaign_participate_data);

                        }

                        if(!$campaign_participate_insertOrUpdate){
                            $error=1;
                        }

                        if(!isset($error)){
                            \App\System::EventLogWrite('insert,campaign_participate_tbl',json_encode($campaign_participate_data));
                        }

                    }


                    $question_answer_data['answer_campaign_id']=$campaign_id;
                    $question_answer_data['answer_question_id']=$question_id;
                    $question_answer_data['answer_participate_mobile']=$campaign_participate_mobile;
                    $question_answer_data['question_answer_type']=$select_question->question_type;
                    $question_answer_data['question_answer_title']=$questionanswerinfo['question_answer_title'];
                    $question_answer_data['question_answer_option_1']=$questionanswerinfo['question_option_1'];
                    $question_answer_data['question_answer_option_2']=$questionanswerinfo['question_option_2'];
                    $question_answer_data['question_answer_option_3']=$questionanswerinfo['question_option_3'];
                    $question_answer_data['question_answer_option_4']=$questionanswerinfo['question_option_4'];
                    $question_answer_data['question_answer_text_value']=$questionanswerinfo['question_option_new'];
                    $question_answer_data['question_answer_status']=0;
                    $question_answer_data['updated_at']=$now;


                    $question_answer_info = \DB::table('question_answer_tbl')->where('answer_question_id',$question_id)->where('answer_campaign_id',$campaign_id)->where('answer_participate_mobile',$campaign_participate_mobile)->first();

                    if(!empty($question_answer_info)){

                        $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->where('id',$question_answer_info->id)->update($question_answer_data);

                    }else{

                        
                        
                        $participate_info = \DB::table('participate_tbl')->where('participate_mobile',$campaign_participate_mobile)->first();

                        if(!empty($participate_info)){

                            $participate_points=($participate_info->participate_total_earn_points)+($select_question->question_points);

                            $participate_point_update = \DB::table('participate_tbl')->where('participate_mobile',$campaign_participate_mobile)->update(array( 'participate_total_earn_points' => $participate_points));

                            if(!$participate_point_update){
                                $error=1;
                            }
                        }


                        $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->insert($question_answer_data);

                    }


                    if(!$question_answer_insertOrUpdate){
                        $error=1;
                    }


                    if(!isset($error)){

                        // \App\System::EventLogWrite('insert,question_answer_tbl',json_encode($question_answer_data));
                        \DB::commit();

                        
                    }else{
                        \DB::rollback();
                        throw new Exception("Error Processing Request", 1);
                    }



                });


                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Question answer successfully.",
                    "serverReferenceCode"=>$now
                ];


                \App\Api::ResponseLogWrite('Question answer successfully',json_encode($response));
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User Info",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }





    /********************************************
    ## ParticipateQuestionInfo
    *********************************************/

    public function ParticipateQuestionInfo(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $campaign_id=$campaigninfo['campaign_id']; 

                $question_position=$campaigninfo['question_position'];

                $participate_mobile=$userinfo['participate_mobile'];                

                $response['select_campaign'] = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();

                $response['select_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();

                $response['all_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();

                $response['total_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->select(DB::raw('count(*) as user_count'))->count();

                $response['all_district']=\App\Common::AllDistrict();
                $response['all_zone']=\App\Zone::where('zone_status',1)->get();

                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get question info successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["campaign_info"]=$campaign_info;
                $response["question_answer_info"]=$all_content;


                \App\Api::ResponseLogWrite('Get question info successfully',json_encode($response));
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User Info",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }














    /********************************************
    ## surveyerRegistration
    *********************************************/

    public function surveyerRegistration(){
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $surveyer_mobile=$userinfo['surveyer_mobile'];

                if(is_numeric($surveyer_mobile) && strlen($surveyer_mobile) == 11){

                    $surveyer_info =\App\Requester::where('surveyer_mobile',$surveyer_mobile)->first();

                    if(empty($surveyer_info)){

                        $success = \DB::transaction(function () use($request) {

                            $surveyer_profile_image='';
                            $image_type='surveyer';


                            $surveyer_name=$userinfo['surveyer_name'];

                            $slug=explode(' ', strtolower($userinfo['surveyer_name']));
                            $surveyer_name_slug=implode('-', $slug);
                            $data['surveyer_name_slug']=$surveyer_name_slug;

                            /*if($request->file('surveyer_profile_image')!=null){
                                #Image
                                $image = $request->file('surveyer_profile_image');
                                $img_location=$image->getRealPath();
                                $img_ext=$image->getClientOriginalExtension();
                                $surveyer_profile_image=\App\Admin::CommonImageUpload($img_location,$img_ext,$image_type,$surveyer_name);
                            }*/


                            $data['surveyer_name']=$userinfo['surveyer_name'];
                            $data['surveyer_name_slug']=$surveyer_name_slug;
                            $data['surveyer_email']=$userinfo['surveyer_email'];
                            $data['surveyer_mobile']=$userinfo['surveyer_mobile'];
                            $data['surveyer_join_date']=$userinfo['surveyer_join_date'];
                            $data['surveyer_district']=$userinfo['surveyer_district'];
                            $data['surveyer_post_code']=$userinfo['surveyer_post_code'];
                            $data['surveyer_address']=$userinfo['surveyer_address'];
                            $data['surveyer_nid']=$userinfo['surveyer_nid'];
                            $data['surveyer_zone']=$userinfo['surveyer_zone'];
                            $data['surveyer_profile_image']='';
                            $data['surveyer_status']=0;
                           

                            $surveyer_insert=\App\Surveyer::insertGetId($data);

                            $surveyer_info=\App\Surveyer::where('id', $id)->first();

                            $login_data['name']=ucwords($userinfo['surveyer_name']);
                            $login_data['name_slug']=$surveyer_name_slug;
                            $login_data['user_type']='surveyer';
                            $login_data['user_role']='surveyer';
                            $login_data['email']=$userinfo['surveyer_email'];
                            $login_data['user_mobile']=$userinfo['surveyer_mobile'];
                            $login_data['user_profile_image']=$surveyer_profile_image;
                            $login_data['surveyer_id']=$surveyer_insert;
                            $login_data['login_status']='0';
                            $login_data['status']='active';
                            $login_data['password']=bcrypt($userinfo['password']);
                            $login_data['updated_at']=$now;

                            // $login_data_insert=\App\User::insertGetId($login_data);

                            $login_data_insert = \App\User::updateOrCreate(
                                [
                                    'user_mobile' => $login_data['user_mobile'],
                                ],
                                $login_data
                            );


                            if(!$surveyer_insert || !$login_data_insert ){
                                $error=1;
                            }

                            if(!isset($error)){
                                \App\System::EventLogWrite('insert,surveyer_tbl',json_encode($data));
                                \App\System::EventLogWrite('insert,users',json_encode($login_data));
                                \DB::commit();
                            }else{
                                \DB::rollback();
                                throw new Exception("Error Processing Request", 1);
                            }
                            
                        });


                        $response["success"]= [
                            "statusCode"=> 200,
                            "successMessage"=> "Surveyer Created Successfully.",
                            "serverReferenceCode"=>$now
                        ];

                        $response["surveyerinfo"]=$surveyer_info;


                        \App\Api::ResponseLogWrite('Surveyer Created Successfully',json_encode($response));
                        return \Response::json($response);



                    }else{

                        $response["errors"]= [
                            "statusCode"=> 403,
                            "errorMessage"=> "Already you are registerd.",
                            "serverReferenceCode"=> $now
                        ];

                        \App\Api::ResponseLogWrite('Invalid Mobile Number.',json_encode($response));

                        return \Response::json($response);
                    }



                }else{

                    $response["errors"]= [
                            "statusCode"=> 403,
                            "errorMessage"=> "Invalid Mobile Number.",
                            "serverReferenceCode"=> $now
                        ];

                    \App\Api::ResponseLogWrite('Invalid Mobile Number.',json_encode($response));

                    return \Response::json($response);
                } 


            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "IMEI Number or Access Token is invalid",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('IMEI Number or Access Token is invalid',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }



    /********************************************
    ## getSurveyerInfo
    *********************************************/

    public function getSurveyerInfo(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $surveyer_mobile=$userinfo['surveyer_mobile'];

                $surveyer_info=\DB::table('surveyer_tbl')
                ->where('surveyer_mobile', $surveyer_mobile)
                ->first();

                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Surveyer Info Successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["surveyerinfo"]=$surveyer_info;

                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User Info",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## getSurveyerCampaignInfo
    *********************************************/

    public function getSurveyerCampaignInfo(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){


                $surveyer_mobile=$userinfo['surveyer_mobile'];

                $surveyer_assign_info =  \App\SurveyerAssign::
                    where('surveyer_assign_tbl.assign_surveyer_mobile',$surveyer_mobile)
                    ->orderby('id','desc')
                    ->select('surveyer_assign_tbl.assign_campaign_id')
                    ->get()->toArray();

                if(!empty($surveyer_assign_info)){

                    $all_content =  \App\Campaign::orderby('id','desc')
                    ->whereIn('campaign_tbl.id',$surveyer_assign_info)
                    ->get();

                }else{
                    $all_content = '';
                }


                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Surveyer Info Successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["all_content"]=$all_content;

                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User Info",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## getAllContentCountdown
    *********************************************/

    public function getSurveyerAllContentCountdown(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';

            $surveyer_mobile=$userinfo['surveyer_mobile'];


            if(!empty($userinfo) && !empty($campaigninfo)){


                if(isset($campaigninfo['search_campaign_id'])){

                    $total_participate =  \App\CampaignParticipate::where(function($query){
                        if(isset($campaigninfo['search_campaign_id'])){
                            $query->where(function ($q){
                                $q->where('participate_campaign_id', $campaigninfo['search_campaign_id']);
                            });
                        }
                    })
                        ->orderBy('id','DESC')
                        ->count();



                    $numberOfQuestions = \DB::table('question_answer_tbl')->where('answer_campaign_id', $campaigninfo['search_campaign_id'])->select('answer_question_id','question_answer_title',DB::raw('count(*) as num'))->groupBy('answer_question_id','question_answer_title')->get();


                    $all_content =  \App\QuestionAnswer::where(function($query){
                        if(isset($campaigninfo['search_campaign_id'])){
                            $query->where(function ($q){
                                $q->where('answer_campaign_id', $campaigninfo['search_campaign_id']);
                            });
                        }
                    })
                        ->where('surveyer_assign_tbl.assign_surveyer_mobile',$surveyer_mobile)
                        ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_answer_tbl.answer_campaign_id')
                        ->join('question_tbl', 'question_tbl.id', '=', 'question_answer_tbl.answer_question_id')
                        ->orderBy('question_answer_tbl.id','DESC')
                        ->select('question_answer_tbl.id AS question_answer_id', 'campaign_tbl.*' , 'question_tbl.*', 'question_answer_tbl.*')
                        ->get();
                        // ->paginate(20);

                    // $search_campaign_id = isset($_GET['search_campaign_id'])? $_GET['search_campaign_id']:0;

                    // $all_content->setPath(url('/surveyer/participate/countdown'));
                    // $pagination = $all_content->appends(['search_campaign_id' => $search_campaign_id])->render();
                    // $data['pagination'] = $pagination;
                    // $data['perPage'] = $all_content->perPage();
                    // $data['all_content'] = $all_content;

                    $response["all_content"]=$all_content;
                    $response["total_participate"]=$total_participate;
                    $response["numberOfQuestions"]=$numberOfQuestions;


                }



                $surveyer_assign_info =  \App\SurveyerAssign::
                where('surveyer_assign_tbl.assign_surveyer_mobile',$surveyer_mobile)
                ->orderby('id','desc')
                ->select('surveyer_assign_tbl.assign_campaign_id')
                ->get()->toArray();

                if(!empty($surveyer_assign_info)){

                    $all_campaign =  \App\Campaign::orderby('id','desc')
                    ->whereIn('campaign_tbl.id',$surveyer_assign_info)
                    ->get();
                    $response["all_campaign"]=$all_campaign;

                }



                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Surveyer Info Successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["all_content"]=$all_content;

                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }







    /********************************************
    ## getAllSingleQuestionAnswer
    *********************************************/

    public function getAllSingleQuestionAnswer(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $questioninfo = \Request::input('questioninfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';

            $surveyer_mobile=$userinfo['surveyer_mobile'];


            if(!empty($userinfo) && !empty($questioninfo)){

                $answer_question_id = $questioninfo['answer_question_id'];
                $total_content= \DB::table('question_answer_tbl')
                    ->where('answer_question_id',$answer_question_id)->count();
                $response['total_content'] = $total_content;

                $question_answer_option_1 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_1','!=', '')->count();
                $response['question_answer_option_1'] = $question_answer_option_1;

                $question_answer_option_2 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_2','!=', '')->count();
                $response['question_answer_option_2'] = $question_answer_option_2;


                $question_answer_option_3 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_3','!=', '')->count();
                $response['question_answer_option_3'] = $question_answer_option_3;


                $question_answer_option_4 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_4','!=', '')->count();
                $response['question_answer_option_4'] = $question_answer_option_4;


                $question_answer_text_value = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_text_value','!=', '')->count();
                $response['question_answer_text_value'] = $question_answer_text_value;

                $all_content= \DB::table('question_answer_tbl')
                    ->where('answer_question_id',$answer_question_id)
                    ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_answer_tbl.answer_campaign_id')
                    ->join('question_tbl', 'question_tbl.id', '=', 'question_answer_tbl.answer_question_id')
                    ->orderBy('question_answer_tbl.id','DESC')
                    ->select('question_answer_tbl.id AS question_answer_id', 'campaign_tbl.*' , 'question_tbl.*', 'question_answer_tbl.*')
                    ->get();
                    // ->paginate(20);
                /*$all_content->setPath(url('/surveyer/participate/question-'.$answer_question_id));
                $pagination = $all_content->render();
                $data['perPage'] = $all_content->perPage();
                $data['pagination'] = $pagination;*/
                $response['all_content'] = $all_content;



                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Surveyer Info Successfully.",
                    "serverReferenceCode"=>$now
                ];

                $response["all_content"]=$all_content;

                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## getSurveyerPaymentInfo
    *********************************************/

    public function getSurveyerPaymentInfo(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $questioninfo = \Request::input('questioninfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';

            $surveyer_mobile=$userinfo['surveyer_mobile'];


            if(!empty($userinfo) && !empty($questioninfo)){

                $answer_question_id = $questioninfo['answer_question_id'];

                $all_content= \App\EarnPaid::where('earn_paid_surveyer_mobile', $surveyer_mobile)->orderBy('id','DESC')->get();

                $response['all_content'] = $all_content;

                $response['surveyer_info'] =  \App\Surveyer::where('surveyer_mobile', $surveyer_mobile)->orderby('id','desc')->first();


                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Surveyer Info Successfully.",
                    "serverReferenceCode"=>$now
                ];


                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## getSurveyerQuestionAnswerList
    *********************************************/

    public function getSurveyerQuestionAnswerList(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';

            $surveyer_mobile=$userinfo['surveyer_mobile'];


            if(!empty($userinfo)){

                $surveyer_info =  \App\Surveyer::
                    where('surveyer_mobile',$surveyer_mobile)
                    ->first();

                if(!empty($userinfo)){
                    
                    $all_content=\DB::table('question_answer_tbl')
                                    ->where('question_answer_tbl.answer_surveyer_id',$surveyer_info->id)
                                    ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_answer_tbl.answer_campaign_id')
                                    ->join('surveyer_tbl', 'surveyer_tbl.id', '=', 'question_answer_tbl.answer_surveyer_id')
                                    ->join('question_tbl', 'question_tbl.id', '=', 'question_answer_tbl.answer_question_id')
                                    ->orderBy('question_answer_tbl.id','DESC')
                                    ->select('question_answer_tbl.id AS question_answer_id', 'campaign_tbl.*', 'surveyer_tbl.*', 'question_tbl.*', 'question_answer_tbl.*')
                                    ->get();

                    $response['all_content'] = $all_content;


                    $surveyer_assign_info =  \App\SurveyerAssign::
                        where('surveyer_assign_tbl.assign_surveyer_mobile',$surveyer_mobile)
                        ->orderby('id','desc')
                        ->select('surveyer_assign_tbl.id')
                        ->get()->toArray();

                    if(!empty($data['surveyer_assign_info'])){

                        $response['all_campaign'] =  \App\Campaign::orderby('id','desc')
                        ->whereIn('campaign_tbl.id',$surveyer_assign_info)
                        ->get();
                    }



                        $response["success"]= [
                            "statusCode"=> 200,
                            "successMessage"=> "Get Surveyer Info Successfully.",
                            "serverReferenceCode"=>$now
                        ];


                        \App\System::APILogWrite(\Request::all(),$response);
                        return \Response::json($response);

                }else{

                    $response["errors"]= [
                            "statusCode"=> 403,
                            "errorMessage"=> "Invalid Surveyer",
                            "serverReferenceCode"=> $now
                        ];

                    \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                    return \Response::json($response);
                }

            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## getCampaignFirstQuestionInfo
    *********************************************/

    public function getCampaignFirstQuestionInfo(){
        
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';



            if(!empty($userinfo) && !empty($campaigninfo)  && !empty($answerinfo)){


                $surveyer_mobile=$userinfo['surveyer_mobile'];
                $participate_mobile=$userinfo['participate_mobile'];
                $campaign_id=$campaigninfo['campaign_id'];
                $participate_mobile=$campaigninfo['participate_mobile'];

                $response['participate_info'] =  \App\Participate::where('participate_mobile',$participate_mobile)->first();

                $response['select_surveyer'] = \DB::table('surveyer_tbl')->where('surveyer_mobile',$surveyer_mobile)->first();
                $response['select_campaign'] = \DB::table('campaign_tbl')->where('id',$campaign_id)->first();
                $response['all_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();
                $response['select_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position','1')->where('question_status','1')->orderby('id','desc')->first();
                $response['total_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->select(DB::raw('count(*) as user_count'))->count();

                $response['all_district']=\App\Common::AllDistrict();
                $response['all_zone']=\App\Zone::where('zone_status',1)->get();
                $response['campaign_participate_mobile'] = $participate_mobile;


                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Campaign Question Successfully.",
                    "serverReferenceCode"=>$now
                ];


                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## FirstQuestionAnswerStore
    *********************************************/

    public function FirstQuestionAnswerStore(){
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');
            $answerinfo = \Request::input('answerinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';



            if(!empty($userinfo) && !empty($campaigninfo)  && !empty($answerinfo)){

                $next_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_next_position)->where('question_status','1')->first();

                $success = \DB::transaction(function () use($request) {

                    $surveyer_mobile=$userinfo['surveyer_mobile'];
                    $campaign_id=$campaigninfo['campaign_id'];
                    $participate_mobile=$campaigninfo['participate_mobile'];

                    $surveyer_id=$answerinfo['surveyer_id'];
                    $question_position=$answerinfo['question_position'];
                    $question_next_position = $question_position + 1;


                    $select_surveyer = \DB::table('surveyer_tbl')->where('id',$surveyer_id)->where('surveyer_status','1')->orderby('id','desc')->first();
                    $select_campaign = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();
                    $select_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();
                    $all_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();


                    if(isset($select_question) && (($select_question->question_position) == 1)){

                        $question_id = $select_question->id;

                        $participate_profile_image='';
                        $image_type='participate';

                        $participate_name=$answerinfo['participate_name'];

                        $slug=explode(' ', strtolower($answerinfo['participate_name']));
                        $participate_name_slug=implode('-', $slug);
                        $data['participate_name_slug']=$participate_name_slug;

                        /*if($request->file('participate_profile_image')!=null){
                            #ImageUpload
                            $image_wide = $request->file('participate_profile_image');
                            $img_location_wide=$image_wide->getRealPath();
                            $img_ext_wide=$image_wide->getClientOriginalExtension();
                            $participate_profile_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$participate_name);
                        }*/


                        $data['participate_name']=$answerinfo['participate_name'];
                        $data['participate_name_slug']=$answerinfo['participate_name_slug'];
                        $data['participate_email']=$answerinfo['participate_email'];
                        $data['participate_mobile']=$answerinfo['participate_mobile'];
                        $data['participate_age']=$answerinfo['participate_age'];
                        $data['participate_join_date']=$answerinfo['participate_join_date'];
                        $data['participate_district']=$answerinfo['participate_district'];
                        $data['participate_post_code']=$answerinfo['participate_post_code'];
                        $data['participate_address']=$answerinfo['participate_address'];
                        $data['participate_nid']=$answerinfo['participate_nid'];
                        $data['participate_gender']=$answerinfo['participate_gender'];
                        $data['participate_religion']=$answerinfo['participate_religion'];
                        $data['participate_occupation']=$answerinfo['participate_occupation'];
                        $data['participate_zone']=$answerinfo['participate_zone'];
                        $data['agreed_user']=0;
                        $data['participate_profile_image']=$participate_profile_image;




                        $campaign_participate_data['participate_campaign_id']=$campaign_id;
                        $campaign_participate_data['participate_campaign_name']=$select_campaign->campaign_name;

                        $campaign_participate_data['campaign_participate_mobile']=$answerinfo['participate_mobile'];
                        $campaign_participate_data['campaign_participate_occupation']=$answerinfo['participate_occupation'];
                        $campaign_participate_data['campaign_participate_age']=$answerinfo['participate_age'];
                        $campaign_participate_data['campaign_participate_district']=$answerinfo['participate_district'];
                        $campaign_participate_data['campaign_participate_post_code']=$answerinfo['participate_post_code'];
                        $campaign_participate_data['campaign_participate_zone']=$answerinfo['participate_zone'];
                        $campaign_participate_data['campaign_participate_address']=$answerinfo['participate_address'];
                        $campaign_participate_data['participate_prize_amount']=$answerinfo['participate_prize_amount'];
                        $campaign_participate_data['campaign_participate_status']=1;



                        $participate_insertOrUpdate = \App\Participate::updateOrCreate(
                            [
                                'participate_mobile' => $data['participate_mobile'],
                            ],
                            $data
                        );


                        $campaign_participate_info = \DB::table('campaign_participate_tbl')->where('participate_campaign_id',$campaign_id)->where('campaign_participate_mobile',$answerinfo['participate_mobile'])->first();

                        if(!empty($campaign_participate_info)){

                            $campaign_participate_insertOrUpdate=\DB::table('campaign_participate_tbl')->where('id',$campaign_participate_info->id)->update($campaign_participate_data);

                        }else{

                            $campaign_participate_insertOrUpdate=\DB::table('campaign_participate_tbl')->insert($campaign_participate_data);

                        }

                    }

                    $question_answer_data['answer_surveyer_id']=$surveyer_id;
                    $question_answer_data['answer_campaign_id']=$campaign_id;
                    $question_answer_data['answer_question_id']=$question_id;

                    $question_answer_data['answer_participate_mobile']=$answerinfo['participate_mobile'];
                    $question_answer_data['question_answer_type']=$select_question->question_type;
                    $question_answer_data['question_answer_title']=$answerinfo['question_answer_title'];
                    $question_answer_data['question_answer_option_1']=$answerinfo['question_option_1'];
                    $question_answer_data['question_answer_option_2']=$answerinfo['question_option_2'];
                    $question_answer_data['question_answer_option_3']=$answerinfo['question_option_3'];
                    $question_answer_data['question_answer_option_4']=$answerinfo['question_option_4'];
                    $question_answer_data['question_answer_text_value']=$answerinfo['question_option_new'];
                    $question_answer_data['question_answer_status']=0;


                    $question_answer_info = \DB::table('question_answer_tbl')->where('answer_question_id',$question_id)->where('answer_campaign_id',$campaign_id)->where('answer_participate_mobile',$answerinfo['participate_mobile'])->first();

                    if(!empty($question_answer_info)){

                        $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->where('id',$question_answer_info->id)->update($question_answer_data);

                    }else{

                        $participate_info = \DB::table('participate_tbl')->where('participate_mobile',$answerinfo['participate_mobile'])->first();

                        if(!empty($participate_info)){

                            $participate_points=($participate_info->participate_total_earn_points)+($select_question->question_points);

                            $participate_point_update = \DB::table('participate_tbl')->where('participate_mobile',$answerinfo['participate_mobile'])->update(array( 'participate_total_earn_points' => $participate_points));

                            if(!$participate_point_update){
                                $error=1;
                            }
                        }

                        $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->insert($question_answer_data);

                    }



                    if(!$participate_insertOrUpdate || !$campaign_participate_insertOrUpdate || !$question_answer_insertOrUpdate){
                        $error=1;
                    }


                    if(!isset($error)){
                        \App\System::EventLogWrite('insert,participate_tbl',json_encode($data));
                        \App\System::EventLogWrite('insert,campaign_participate_tbl',json_encode($campaign_participate_data));
                        \App\System::EventLogWrite('insert,question_answer_tbl',json_encode($question_answer_data));
                        \DB::commit();

                        
                    }else{
                        \DB::rollback();
                        throw new Exception("Error Processing Request", 1);
                    }



                });


                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Question Answer Successfully.",
                    "serverReferenceCode"=>$now
                ];


                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign or invalid question",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## getCampaignQuestionInfo
    *********************************************/

    public function getCampaignQuestionInfo(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';



            if(!empty($userinfo) && !empty($campaigninfo)  && !empty($answerinfo)){

                $surveyer_mobile=$userinfo['surveyer_mobile'];
                $campaign_id=$campaigninfo['campaign_id'];
                $participate_mobile=$campaigninfo['participate_mobile'];


                $response['select_surveyer'] = \DB::table('surveyer_tbl')->where('surveyer_mobile',$surveyer_mobile)->first();
                $response['select_campaign'] = \DB::table('campaign_tbl')->where('id',$campaign_id)->first();
                $response['all_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();
                $response['total_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->select(DB::raw('count(*) as user_count'))->count();

                $response['all_district']=\App\Common::AllDistrict();
                $response['all_zone']=\App\Zone::where('zone_status',1)->get();
                $response['campaign_participate_mobile'] = $participate_mobile;


                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Campaign Question Successfully.",
                    "serverReferenceCode"=>$now
                ];


                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## QuestionAnswerStore
    *********************************************/

    public function QuestionAnswerStore(){
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');
            $answerinfo = \Request::input('answerinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';



            if(!empty($userinfo) && !empty($campaigninfo)  && !empty($answerinfo)){

                $surveyer_mobile=$userinfo['surveyer_mobile'];
                $campaign_id=$campaigninfo['campaign_id'];
                $participate_mobile=$campaigninfo['participate_mobile'];



                $surveyer_id=$answerinfo['surveyer_id'];
                $question_position=$answerinfo['question_position'];
                $question_next_position = $question_position + 1;
                $surveyer_id=$answerinfo['surveyer_id'];
                $surveyer_id=$answerinfo['surveyer_id'];
            

                $question_next_position = $question_position + 1;
                $next_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_next_position)->where('question_status','1')->first();

                if(!empty($next_question)){

                }

                $total_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->select(DB::raw('count(*) as user_count'))->get();

                $participate_mobile = $campaigninfo['participate_mobile'];

                $success = \DB::transaction(function () use($request) {

                    $surveyer_id = $answerinfo['answer_surveyer_id'];
                    $campaign_id = $answerinfo['answer_campaign_id'];
                    $question_position = $answerinfo['answer_question_position'];
                    $participate_mobile = $answerinfo['campaign_participate_mobile'];


                    $select_surveyer = \DB::table('surveyer_tbl')->where('id',$surveyer_id)->where('surveyer_status','1')->orderby('id','desc')->first();
                    $select_campaign = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();
                    $select_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();
                    $all_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();

                    $question_id = $select_question->id;


                    // if($question_position != 1){


                        $question_answer_data['answer_campaign_id']=$campaign_id;
                        $question_answer_data['answer_surveyer_id']=$surveyer_id;
                        $question_answer_data['answer_question_id']=$question_id;

                        $question_answer_data['answer_participate_mobile'] = $answerinfo['campaign_participate_mobile'];
                        $question_answer_data['question_answer_type'] = $select_question->question_type;
                        $question_answer_data['question_answer_title'] = $answerinfo['question_answer_title'];
                        $question_answer_data['question_answer_option_1'] = $answerinfo['question_option_1'];
                        $question_answer_data['question_answer_option_2'] = $answerinfo['question_option_2'];
                        $question_answer_data['question_answer_option_3'] = $answerinfo['question_option_3'];
                        $question_answer_data['question_answer_option_4'] = $answerinfo['question_option_4'];
                        $question_answer_data['question_answer_text_value'] = $answerinfo['question_option_new'];
                        $question_answer_data['question_answer_status'] = 0;



                        $question_answer_info = \DB::table('question_answer_tbl')->where('answer_question_id',$question_id)->where('answer_campaign_id',$campaign_id)->where('answer_participate_mobile',$participate_mobile)->first();
                        
                        if(!empty($question_answer_info)){

                            $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->where('id',$question_answer_info->id)->update($question_answer_data);

                        }else{


                            $participate_info = \DB::table('participate_tbl')->where('participate_mobile',$participate_mobile)->first();

                            if(!empty($participate_info)){

                                $participate_points=($participate_info->participate_total_earn_points)+($select_question->question_points);

                                $participate_point_update = \DB::table('participate_tbl')->where('participate_mobile',$participate_mobile)->update(array( 'participate_total_earn_points' => $participate_points));

                                if(!$participate_point_update){
                                    $error=1;
                                }
                            }

                            $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->insert($question_answer_data);

                        }


                        if(!$question_answer_insertOrUpdate){
                            $error=1;
                        }

                        if(!isset($error)){
                            \App\System::EventLogWrite('insert,question_answer_tbl',json_encode($question_answer_data));
                            \DB::commit();
                            
                        }else{
                            \DB::rollback();
                            throw new Exception("Error Processing Request", 1);
                        }


                    // }else{
                    //     return redirect()->to('/surveyer/question/answer/'.$surveyer_id.'/'.$campaign_id.'/1')->with('message','First Question Answer');
                    //  }

                });

                /*if(!empty($next_question)){
                    return redirect()->to('/surveyer/all/question/answer/'.$participate_mobile.'/'.$surveyer_id.'/'.$campaign_id.'/'. $question_next_position)->with('message','Question Answer Successfully');
                }else{
                    return redirect()->to('/surveyer/participate/campaign/list/')->with('message','Camapaign Participate Successfully');
                }*/




                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Question Answer Successfully.",
                    "serverReferenceCode"=>$now
                ];


                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign or invalid question",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User Info',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }














    /********************************************
    ## requesterRegistration
    *********************************************/

    public function requesterRegistration(){
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $requester_mobile=$userinfo['requester_mobile'];

                if(is_numeric($requester_mobile) && strlen($requester_mobile) == 11){


                    $requester_info =\App\Requester::where('requester_mobile',$requester_mobile)->first();

                    if(empty($requester_info)){


                        $success = \DB::transaction(function () use($request) {

                            $requester_profile_image='';
                            $image_type='requester';

                            $requester_name=$userinfo['requester_name'];

                            $slug=explode(' ', strtolower($userinfo['requester_name']));
                            $requester_name_slug=implode('-', $slug);
                            $data['requester_name_slug']=$requester_name_slug;



                            /*if($request->file('requester_profile_image')!=null){
                                #ImageUpload
                                $image_wide = $request->file('requester_profile_image');
                                $img_location_wide=$image_wide->getRealPath();
                                $img_ext_wide=$image_wide->getClientOriginalExtension();
                                $requester_profile_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$requester_name);
                            }*/

                            $data['requester_name']=$userinfo['requester_name'];
                            $data['requester_name_slug']=$requester_name_slug;
                            $data['requester_email']=$userinfo['requester_email'];
                            $data['requester_mobile']=$userinfo['requester_mobile'];
                            $data['requester_join_date']=$userinfo['requester_join_date'];
                            $data['requester_district']=$userinfo['requester_district'];
                            $data['requester_post_code']=$userinfo['requester_post_code'];
                            $data['requester_address']=$userinfo['requester_address'];
                            $data['requester_nid']=$userinfo['requester_nid'];
                            $data['requester_profile_image']=$requester_profile_image;
                            $data['requester_status']=0;

                            $requester_insert=\App\Requester::insertGetId($data);


                            $login_data['name']=ucwords($userinfo['requester_name']);
                            $login_data['name_slug']=$requester_name_slug;
                            $login_data['user_type']='requester';
                            $login_data['user_role']='requester';
                            $login_data['email']=$userinfo['requester_email'];
                            $login_data['user_mobile']=$userinfo['requester_mobile'];
                            $login_data['user_profile_image']=$requester_profile_image;
                            $login_data['requester_id']=$requester_insert;
                            $login_data['login_status']='0';
                            $login_data['status']='active';
                            $login_data['password']=bcrypt($userinfo['password']);


                            // $login_data_insert=\App\User::insertGetId($login_data);

                            $login_data_insert = \App\User::updateOrCreate(
                                [
                                    'user_mobile' => $login_data['user_mobile'],
                                ],
                                $login_data
                            );


                            if(!$requester_insert || !$login_data_insert ){
                                $error=1;
                            }

                            if(!isset($error)){
                                \App\System::EventLogWrite('insert,requester_tbl',json_encode($data));
                                \App\System::EventLogWrite('insert,users',json_encode($login_data));
                                \DB::commit();
                            }else{
                                \DB::rollback();
                                throw new Exception("Error Processing Request", 1);
                            }
                            
                        });

                        

                        $response["success"]= [
                            "statusCode"=> 200,
                            "successMessage"=> "Requester Created Successfully.",
                            "serverReferenceCode"=>$now
                        ];

                        $response["participateinfo"]=$participate_registration_info;


                        \App\Api::ResponseLogWrite('Requester Created Successfully',json_encode($response));
                        return \Response::json($response);


                    }else{

                        $response["errors"]= [
                            "statusCode"=> 403,
                            "errorMessage"=> "Already you are registerd.",
                            "serverReferenceCode"=> $now
                        ];

                        \App\Api::ResponseLogWrite('Invalid Mobile Number.',json_encode($response));

                        return \Response::json($response);
                    }



                }else{

                    $response["errors"]= [
                            "statusCode"=> 403,
                            "errorMessage"=> "Invalid Mobile Number.",
                            "serverReferenceCode"=> $now
                        ];

                    \App\Api::ResponseLogWrite('Invalid Mobile Number.',json_encode($response));

                    return \Response::json($response);
                } 


            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "IMEI Number or Access Token is invalid",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('IMEI Number or Access Token is invalid',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }



    /********************************************
    ## RequesterAllContentCountdown
    *********************************************/

    public function RequesterAllContentCountdown(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if(!empty($userinfo)){

                $campaign_id=$userinfo['campaign_id'];
                $requester_id=$userinfo['requester_id'];

            
                if(isset($campaign_id)){

                    $total_participate =  \App\CampaignParticipate::where(function($query){
                        if(isset($campaign_id)){
                            $query->where(function ($q){
                                $q->where('participate_campaign_id', $campaign_id);
                            });
                        }
                    })
                        ->orderBy('id','DESC')
                        ->count();

                    $response['total_participate'] = $total_participate;


                    $numberOfQuestions = \DB::table('question_answer_tbl')->where('answer_campaign_id', $campaign_id)->select('answer_question_id','question_answer_title',DB::raw('count(*) as num'))->groupBy('answer_question_id','question_answer_title')->get();
                    $response['numberOfQuestions'] = $numberOfQuestions;


                    $all_content =  \App\QuestionAnswer::where(function($query){
                        if(isset($campaign_id)){
                            $query->where(function ($q){
                                $q->where('answer_campaign_id', $campaign_id);
                            });
                        }
                    })
                        ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_answer_tbl.answer_campaign_id')
                        ->join('question_tbl', 'question_tbl.id', '=', 'question_answer_tbl.answer_question_id')
                        ->orderBy('question_answer_tbl.id','DESC')
                        ->select('question_answer_tbl.id AS question_answer_id', 'campaign_tbl.*' , 'question_tbl.*', 'question_answer_tbl.*')
                        ->get();

                    $response['all_content'] = $all_content;

                }


                $response['all_campaign'] =  \App\Campaign::orderby('id','desc')->where('campaign_requester_id', $requester_id)->get();




                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Question Answer Successfully.",
                    "serverReferenceCode"=>$now
                ];


                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User or invalid campaign',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## getRequesterAllSingleQuestionAnswer
    *********************************************/

    public function getRequesterAllSingleQuestionAnswer(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if(!empty($userinfo)){

                $campaign_id=$userinfo['campaign_id'];
                $requester_id=$userinfo['requester_id'];
                $answer_question_id=$userinfo['answer_question_id'];

                $total_content= \DB::table('question_answer_tbl')
                    ->where('answer_question_id',$answer_question_id)->count();
                $response['total_content'] = $total_content;

                $question_answer_option_1 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_1','!=', '')->count();
                $response['question_answer_option_1'] = $question_answer_option_1;

                $question_answer_option_2 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_2','!=', '')->count();
                $response['question_answer_option_2'] = $question_answer_option_2;


                $question_answer_option_3 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_3','!=', '')->count();
                $response['question_answer_option_3'] = $question_answer_option_3;


                $question_answer_option_4 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_4','!=', '')->count();
                $response['question_answer_option_4'] = $question_answer_option_4;


                $question_answer_text_value = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_text_value','!=', '')->count();
                $response['question_answer_text_value'] = $question_answer_text_value;

                $all_content= \DB::table('question_answer_tbl')
                    ->where('answer_question_id',$answer_question_id)
                    ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_answer_tbl.answer_campaign_id')
                    ->join('question_tbl', 'question_tbl.id', '=', 'question_answer_tbl.answer_question_id')
                    ->orderBy('question_answer_tbl.id','DESC')
                    ->select('question_answer_tbl.id AS question_answer_id', 'campaign_tbl.*' , 'question_tbl.*', 'question_answer_tbl.*')
                    ->get();

                $response['all_content'] = $all_content;



                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Question Answer Successfully.",
                    "serverReferenceCode"=>$now
                ];


                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);



            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User or invalid campaign',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## RequesterPaymentList
    *********************************************/

    public function RequesterPaymentList(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if(!empty($userinfo)){

                $campaign_id=$userinfo['campaign_id'];
                $requester_id=$userinfo['requester_id'];

                $all_content= \App\CampaignPayment::orderBy('id','DESC')->get();
                $response['all_content'] = $all_content;

                $response['all_data'] =  \App\CampaignPayment::orderby('id','desc')->get();
                $response['requester_info'] =  \App\Requester::where('id', $requester_id)->orderby('id','desc')->first();

                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get Request Payment Successfully.",
                    "serverReferenceCode"=>$now
                ];


                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);


            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User or invalid campaign',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }


    /********************************************
    ## RequesterCampaignList
    *********************************************/

    public function RequesterCampaignList(){

        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if(!empty($userinfo)){

                $campaign_id=$userinfo['campaign_id'];
                $requester_id=$userinfo['requester_id'];

                $all_content= \App\Campaign::orderBy('id','DESC')->where('campaign_requester_id',$requester_id)->get();

                $response['all_content'] = $all_content;

                $response['all_data'] =  \App\Campaign::orderby('id','desc')->where('campaign_requester_id',$requester_id)->get();

                $response["success"]= [
                    "statusCode"=> 200,
                    "successMessage"=> "Get All Campaign Successfully.",
                    "serverReferenceCode"=>$now
                ];


                \App\System::APILogWrite(\Request::all(),$response);
                return \Response::json($response);


            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid User or invalid campaign",
                        "serverReferenceCode"=> $now
                    ];

                \App\Api::ResponseLogWrite('Invalid User or invalid campaign',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];


            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

            \App\System::ErrorLogWrite($message);
            \App\Api::ResponseLogWrite($message,json_encode($response));
            return \Response::json($response);
        }


    }








}
