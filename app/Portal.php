<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
    
    /**
     * get cookie.
     *
     * @param int $count
     * @return mixed
     */
    public static function getCookie()
    {

        if(\Cookie::has('mobile')){
            $cookie_value = \Cookie::get('mobile');
        	return $cookie_value;
        }else{
            return redirect()->to('/participate/registration');
        }
    }



}
