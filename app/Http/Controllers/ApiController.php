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
                $data['user_mobile'] ='01912582254';

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
            /*$block_check =\App\Subscription::MnpIPBlockCheck($mobile_number);
            return response()->json($block_check);*/
            $response =\App\Subscription::MnpIPBlockCheck($mobile_number);

        } else {
            // return response()->json(['msisdn'=>'NO_MSISDN','operator'=>'blink']);
            $response = ['msisdn'=>'NO_MSISDN','operator'=>'blink'];
        }

        \App\System::APILogWrite(\Request::all(),$response);
        return \Response::json($response);

    }




}
