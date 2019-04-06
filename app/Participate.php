<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participate extends Model
{
    
    protected $table='participate_tbl';

    protected $fillable = [
        'participate_name',
        'participate_name_slug',
        'participate_email',
        'participate_join_date',
        'participate_mobile',
        'participate_age',
        'participate_religion',
        'participate_occupation',
        'participate_gender',
        'participate_zone',
        'participate_district',
        'participate_address',
        'participate_post_code',
        'participate_nid',
        'participate_profile_image',
        'participate_total_earn',
        'participate_total_paid_earn',
        'participate_number_of_campaign',
        'participate_number_of_gift_winner',
        'agreed_user',
        'participate_status',
        'participate_created_by',
        'participate_updated_by'
    ];

    /**
     * get all content.
     *
     * @param int $count
     * @return mixed
     */
    public static function getAllContent($count)
    {
        $data = Participate::where('participate_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
