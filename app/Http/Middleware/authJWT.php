<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class authJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $now=date('Y-m-d H:i:s');
        try {

            $user = JWTAuth::parseToken()->authenticate();
            \App\System::CustomLogWritter("apilog","jwt_log",$user);

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

                $response["errors"]= [
                    "statusCode"=> 503,
                    "errorMessage"=> 'Token is Invalid',
                    "serverReferenceCode"=> $now,
                ];
                ###***********Text Log**************************###
                $logmessage = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                $message = PHP_EOL."Request :".json_encode($request->all())."Response :".json_encode($response)."Error :".$logmessage;

                \App\System::CustomLogWritter("apilog","jwt_log",$message);
                return response()->json($response);

            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

                $response["errors"]= [
                    "statusCode"=> 505,
                    "errorMessage"=> 'Token is Expired',
                    "serverReferenceCode"=> $now,
                ];
                ###***********Text Log**************************###
                $logmessage = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                $message = PHP_EOL."Request :".json_encode($request->all())."Response :".json_encode($response)."Error :".$logmessage;

                \App\System::CustomLogWritter("apilog","jwt_log",$message);
                return response()->json($response);

            }else{

                $response["errors"]= [
                    "statusCode"=> 507,
                    "errorMessage"=> 'Something is wrong Token',
                    "serverReferenceCode"=> $now,
                ];

                ###***********Text Log**************************###
                $logmessage = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                $message = PHP_EOL."Request :".json_encode($request->all())."Response :".json_encode($response)."Error :".$logmessage;

                \App\System::CustomLogWritter("apilog","jwt_log",$message);
                return response()->json($response);

            }
        }

        return $next($request);
    }





}
