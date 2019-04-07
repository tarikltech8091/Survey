<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surveyer extends Model
{
    
    protected $table='surveyer_tbl';

    protected $fillable = [
        'surveyer_name',
        'surveyer_name_slug',
        'surveyer_email',
        'surveyer_mobile',
        'surveyer_join_date',
        'surveyer_district',
        'surveyer_address',
        'surveyer_post_code',
        'surveyer_nid',
        'surveyer_zone',
        'surveyer_profile_image',
        'surveyer_total_participate',
        'surveyer_total_success_participate',
        'surveyer_total_earn',
        'surveyer_total_paid',
        'surveyer_status',
        'surveyer_created_by',
        'surveyer_updated_by'
    ];

    /**
     * get all content.
     *
     * @param int $count
     * @return mixed
     */
    public static function getAllContent($count)
    {
        $data = Surveyer::where('surveyer_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
