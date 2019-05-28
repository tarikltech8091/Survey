<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    

    /********************************************
    ## RequestLogWrite 
    *********************************************/
    public static function RequestLogWrite($inputs){

        $page_title = \Request::route()->getName();
        $page_url   = \Request::fullUrl();
        $client_ip  = \App\System::get_client_ip();
        $client_info  = \App\System::getBrowser();
        $client_location  = \App\System::geolocation($client_ip);

        if(\Auth::check()){
            $user_id=  \Auth::user()->id;
        }else
        $user_id= 'guest';


        $request_city = isset($client_location['city']) ? $client_location['city'] : '' ;
        $request_division = isset($client_location['division']) ? $client_location['division'] : '' ;
        $request_country = isset($client_location['country']) ? $client_location['country'] : '' ;

    
        $now = date('Y-m-d H:i:s');
        /*$request_data = [
                            'request_client_ip' => $client_ip,
                            'request_user_id'   => $user_id,
                            'request_browser'   => $client_info['browser'],
                            'request_platform'  => $client_info['platform'],
                            'request_city'      => $request_city,
                            'request_division'  => $request_division,
                            'request_country'   => $request_country,
                            'request_url'		=> $page_url,
                            'request_message'   => json_encode($inputs),
                            'created_at'       => $now,
                            'updated_at'       => $now 

                        ];

         $request_id=\DB::table('request_log')->insertGetId($request_data);*/


        /***********Text Log**************************/

        $message = $client_ip.'|'.$user_id.'|'.$page_title.'|'.$page_url.'| '.json_encode($inputs).' |'.$client_info['browser'].'|'.$client_info['platform'].'|'.$request_city.'|'.$request_division.'|'.$request_country;

        \App\System::CustomLogWritter("requestlog","request_log",$message);

        return true;

    }



    /********************************************
    ## ResponseLogWrite 
    *********************************************/
    public static function ResponseLogWrite($response_type,$response_data){

        $client_ip  = \App\System::get_client_ip();
        $page_url   = \Request::fullUrl();
        

        if(\Auth::check())
            $user_id = \Auth::user()->id;
        else
            $user_id = 'guest';

        $now = date('Y-m-d H:i:s');

        /*$response_insert = [
                              
                        'response_client_ip' => $client_ip,
                        'response_user_id'   => $user_id,
                        'response_request_url' => $page_url,
                        'response_type'  => $response_type,
                        'response_data'  => $response_data,
                        'created_at'  => $now,
                        'updated_at'  => $now 

                        ];

         \DB::table('response_log')->insert($response_insert);*/


        /***********Text Log**************************/

        $message = $client_ip.'|'.$user_id.'|'.$page_url.'|'.$response_type.'|'.$response_data;

        \App\System::CustomLogWritter("responselog","response_log",$message);

        return true;



    }


}
