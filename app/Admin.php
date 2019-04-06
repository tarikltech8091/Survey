<?php

namespace App;
use App\Image;

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
        if (!file_exists('images/user/'.$image_type.'/small/')) {
            mkdir('images/user/admin/small/', 0777, true);
        }
        $path2 = 'images/user/'.$image_type.'/small/' . $filename;
        Image::make($img_location)->resize(30, 30)->save($path2);
        return $path2;
    }

	/********************************************
    ## CompanyImageUpload
    *********************************************/

	 public static function CompanyImageUpload($img_location, $company_name_slug, $img_ext){

	  $filename  = $company_name_slug.'-'.time().'-'.rand(1111111,9999999).'.'.$img_ext;

	  /*directory create*/
		if (!file_exists('assets/images/company/'))
		   mkdir('assets/images/company/', 0777, true);


	  $path = public_path('assets/images/company/' . $filename);
	  \Image::make($img_location)->resize(117, 30)->save($path);

	  $company_logo='assets/images/company/'.$filename;
	  return $company_logo;
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

    //Image Upload for Live Streaming
    public static function poster_image_live_streaming($img_location, $keywords_type, $img_ext)
    {
        $filename  = $keywords_type.'-'.time().'-'.rand(1111111,9999999).'.'.$img_ext;

        if (!file_exists('images/poster-image/live-streaming/')) {
            mkdir('images/poster-image/live-streaming/', 0777, true);
        }
        $path = 'images/poster-image/live-streaming/'.$filename;
        \Image::make($img_location)->save($path);
        return $path;
    }

    //Image Upload for Data Pack
    public static function data_pack_image($img_location, $keywords_type, $img_ext)
    {
        $filename  = $keywords_type.'-'.time().'-'.rand(1111111,9999999).'.'.$img_ext;
        if (!file_exists('images/data-pack-images/')) {
            mkdir('images/data-pack-images/', 0777, true);
        }
        $path = 'images/data-pack-images/'.$filename;
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
