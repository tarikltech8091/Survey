<?php

namespace App;
use Image;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    

    /**
     * Upload user image.
     *
     * @param string $img_location, $slug, $img_ext
     * @return user profile image.
     */
    public static function UserImageUpload($img_location, $email, $img_ext)
    {
        $filename  = $email.'-'.time().'-'.rand(1111111,9999999).'.'.$img_ext;
        if (!file_exists('images/user/admin/small/')) {
            mkdir('images/user/admin/small/', 0777, true);
        }
        $path2 = 'images/user/admin/small/' . $filename;
        Image::make($img_location)->resize(30, 30)->save($path2);
        return $path2;
    }


    /**
     * Upload user image.
     *
     * @param string $img_location, $slug, $img_ext
     * @return user profile image.
     */
    public static function CommonImageUpload($img_location, $img_ext_wide, $image_type, $name)
    {
        $filename  = $name.'-'.time().'-'.rand(1111111,9999999);
        if (!file_exists('images/survey/'.$image_type.'/small/')) {
            mkdir('images/survey/'.$image_type.'/small/', 0777, true);
        }
        $path2 = 'images/survey/'.$image_type.'/small/' . $filename;
        Image::make($img_location)->save($path2);
        return $path2;
    }


    /**
     * Upload image_teaser
     *
     * @param string $img_location, $keywords_type, $img_ext
     * @return user image_teaser.
     * $category=album category/content category etc.
     */
    public static function poster_image($img_location, $keywords_type, $img_ext,$category)
    {
        $filename  = $keywords_type.'-'.time().'-'.rand(1111111,9999999).'.'.$img_ext;
        if($category=="album content"){
            if (!file_exists('poster-image/surveyer/')) {
                mkdir('poster-image/surveyer/', 0777, true);
            }
            $path = 'poster-image/surveyer/'.$filename;
        }
        if($category=="album"){
            if (!file_exists('poster-image/album/')) {
                mkdir('poster-image/album/', 0777, true);
            }
            $path = 'poster-image/album/'.$filename;
        }
        \Image::make($img_location)->save($path);
        return $path;
    }



    public static function multiArraySerach($search,$search_key,$array){

        foreach ($array as $key => $value) {
            if ($value[$search_key] == $search) {
                return $search;
            }
        }
        return null;
    }

	
}
