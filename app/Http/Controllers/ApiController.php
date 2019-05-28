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
    public function GetAccessToken(Request $request){

        $now=date('Y-m-d H:i:s');
        // try{


            // $user_app_key = $request->input('user_app_key');

            // if(empty($user_app_key))
            //     throw new \Exception("User APP Key is Required.");

            // $data['user_app_key'] = $user_app_key;
            $data['name'] = 'reet';
            // $data['name_slug'] = 'aeerppww';
            // $data['name_slug'] = $request->input('name_slug');
            $data['login_status'] = 0;
            $data['status'] = 'active';
            // $data['created_by'] = 1;
            // $data['updated_by'] = 1;
            $data['user_type'] = 'app';
            // $data['email'] = 'Surveyapp@gmail.com';
            $data['user_role'] = 'Surveyapp';
            $data['password']=\Hash::make('1234');

            if(!empty($request->input('user_mobile')))
                $data['user_mobile'] =$request->input('user_mobile');
                $data['user_mobile'] ='01912552254';

            // if(!empty($request->input('user_imei_info')))
            //     $data['user_imei_info'] = $request->input('user_imei_info');


            $user_info = \App\User::updateOrCreate(
                // ['user_app_key' =>$data['user_app_key']],$data
                ['user_mobile' =>$data['user_mobile']],$data
            );

            if($user_info->wasRecentlyCreated)
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


            if(!$token = \JWTAuth::attempt($data))

            // if(!$token = auth('api')->attempt($data))

                throw new \Exception("Something Wrong In Token");

            $response["access_token"]= $token;



            // \App\System::APILogWrite(\Request::all(),$response);
            return \Response::json($response);


        // }catch(\Exception $e){
        //     $response["errors"]= [
        //         "statusCode"=> 501,
        //         "errorMessage"=> $e->getMessage(),
        //         "serverReferenceCode"=> $now,
        //     ];

        //     $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();

        //     \App\System::ErrorLogWrite($message);
        //     \App\System::APILogWrite(\Request::all(),$response);
        //     return \Response::json($response);
        // }
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


                        $participate_profile_image='';
                        $image_type='participate';

                        $participate_name=$userinfo['participate_name'];
                        $participate_email=$userinfo['participate_email'];
                        $slug=explode(' ', strtolower($userinfo['participate_name']));
                        $participate_name_slug=implode('-', $slug);

                        if($request->file('participate_profile_image')!=null){

                            #ImageUpload
                            /*$image_wide = $request->file('participate_profile_image');
                            $img_location_wide=$image_wide->getRealPath();
                            $img_ext_wide=$image_wide->getClientOriginalExtension();
                            $participate_profile_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$participate_name);*/
                            $participate_profile_image="";

                        }else{
                            $participate_profile_image="";
                        }


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


                        $participate_registration_info=\DB::table('participate_tbl')->insertGetId($client_registration_confirm);

                        // \App\System::EventLogWrite('insert,participate_tbl',json_encode($participate_registration_confirm));

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
    ## ClientDirectLogin
    *********************************************/
    public function ClientDirectLogin(){
        $now=date('Y-m-d H:i:s');
        try{

            $accessinfo = \Request::input('accessinfo');
            $logininfo = \Request::input('logininfo');
            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';

            $get_info=\DB::table('table_app_token')->where('imei_no',$imei_no)->where('access_token',$access_token)->first();


            if(!empty($get_info) && !empty($logininfo)){

                    $user_mobile = $logininfo['mobile'];
                    $push_token = $logininfo['push_token'];
                    $user_platform =$logininfo['user_platform'];


                    $client_user_info=\DB::table('users')->where('mobile',$user_mobile)->where('status','1')->first();

                if(!empty($client_user_info)){

                        $credentials = [
                            'mobile' =>$user_mobile,
                        ];

                        $response["success"]= [
                            "statusCode"=> 200,
                            "successMessage"=> "Successfully Login.",
                            "serverReferenceCode"=>$now
                        ];

                        $response["logininfo"]= $client_user_info;

                        $requestlog_update_data=[
                            "request_response"=>json_encode($response),
                            "updated_at"=>$now,
                        ];
                        $user_update_data=[
                            "push_token"=>$push_token,
                            "user_platform"=>$user_platform,
                            "updated_at"=>$now,
                        ];
                                                
                        $client_registration_update=\DB::table('users')->where('id', $client_user_info->id)->update($user_update_data);

                        \DB::table('request_log')->where('request_id',$this->request_id)->update($requestlog_update_data);

                        \App\Api::ResponseLogWrite('Successfully Login.',json_encode($response));

                        return \Response::json($response);

                }else{
                    $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "Invalid user or block user.",
                        "serverReferenceCode"=> $now
                    ];

                    \DB::table('request_log')->where('request_id',$this->request_id)->update(array("request_response" =>json_encode($response),"updated_at"=>$now));

                    \App\Api::ResponseLogWrite('Invalid user.',json_encode($response));

                    return \Response::json($response);
                }

            }else{

                $response["errors"]= [
                        "statusCode"=> 403,
                        "errorMessage"=> "IMEI Number or Access Token is invalid",
                        "serverReferenceCode"=> $now
                    ];

                \DB::table('request_log')->where('request_id',$this->request_id)->update(array("request_response" =>json_encode($response),"updated_at"=>$now));

                \App\Api::ResponseLogWrite('IMEI Number or Access Token is invalid',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

            $response["errors"]= [
                    "statusCode"=> 501,
                    "errorMessage"=> "Missing or incorrect data, Sorry the requested resource does not exist",
                    "serverReferenceCode"=> $now,
                ];

            \DB::table('request_log')->where('request_id',$this->request_id)->update(array("request_response" =>json_encode($response),"updated_at"=>$now));

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
            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';
            $userinfo = \Request::input('userinfo');



            $get_info=\DB::table('table_app_token')->where('imei_no',$imei_no)->where('access_token',$access_token)->first();
            if(!empty($get_info) && !empty($userinfo)){

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

                //if(!empty($userinfo['user_profile_image'])){

                    //$file_data = $userinfo['user_profile_image'];

                    //$image_path =\App\Admin::AppProfileImageUpload($file_data,$name_slug);
                    //$user_image=$image_path;

                //}
                //else{
                    $user_image=$user_info->user_profile_image;
                //}

                $users_update_data=[
                                "name"=>$name,
                                "name_slug"=>$name_slug,
                                "user_profile_image"=>$user_image,
                                "email"=>$email,
                                "updated_at"=>$now,
                            ];

                $response["success"]= [
                    "statusCode"=> 200,
                    //"successMessage"=> $user_image,
                    "successMessage"=> "Successfully updated",
                    "serverReferenceCode"=>$now
                ];


                $requestlog_update_data=[
                    "request_response"=>json_encode($response),
                    "updated_at"=>$now,
                ];
                \DB::table('request_log')->where('request_id',$this->request_id)->update($requestlog_update_data);
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

                \DB::table('request_log')->where('request_id',$this->request_id)->update(array("request_response" =>json_encode($response),"updated_at"=>$now));

                \App\Api::ResponseLogWrite('IMEI Number or Access Token is invalid',json_encode($response));

                return \Response::json($response);
            }

        }catch(\Exception $e){

             $response["errors"]= [
                "statusCode"=> 501,
                "errorMessage"=>  $e->getMessage(),
                "serverReferenceCode"=> $now,
            ];

            \DB::table('request_log')->where('request_id',$this->request_id)->update(array("request_response" =>json_encode($response),"updated_at"=>$now));

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
    ## GetCampaignInfo
    *********************************************/

    public function GetCampaignInfo(){
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
    ## GetCampaignParticipateInfo
    *********************************************/

    public function GetCampaignParticipateInfo(){
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $participate_mobile=$userinfo['participate_mobile'];

                $all_content= \App\CampaignParticipate::where('campaign_participate_mobile', $participate_mobile)->orderBy('id','DESC')->get();


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
    ## GetQuestionAnswerInfo
    *********************************************/

    public function GetQuestionAnswerInfo(){
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
    ## GetCampaignDetails
    *********************************************/

    public function GetCampaignDetails(){
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
    ## GetParticipateQuestionInfo
    *********************************************/

    public function GetParticipateQuestionInfo(){
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
    ## ParticipateQuestionAnswerStore
    *********************************************/

    public function ParticipateQuestionAnswerStore(){
        $now=date('Y-m-d H:i:s');

        try{

            $accessinfo = \Request::input('accessinfo');
            $userinfo = \Request::input('userinfo');
            $campaigninfo = \Request::input('campaigninfo');
            $questionanswerinfo = \Request::input('questionanswerinfo');

            $imei_no= isset($accessinfo['imei_no']) ? trim($accessinfo['imei_no']):'';
            $access_token= isset($accessinfo['access_token']) ? trim($accessinfo['access_token']):'';


            if( !empty($userinfo)){

                $answer_campaign_id=$campaigninfo['campaign_id'];

                $answer_question_position=$campaigninfo['question_position'];

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

























}
