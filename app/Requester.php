<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requester extends Model
{
    
    protected $table='requester_tbl';

    protected $fillable = [
        'requester_name',
        'requester_name_slug',
        'requester_email',
        'requester_mobile',
        'requester_join_date',
        'requester_district',
        'requester_address',
        'requester_post_code',
        'requester_nid',
        'requester_zone',
        'requester_profile_image',
        'requester_number_of_campaign',
        'requester_number_of_success_campaign',
        'requester_total_invest',
        'requester_status',
        'requester_created_by',
        'requester_updated_by'
    ];

    /**
     * get all content.
     *
     * @param int $count
     * @return mixed
     */
    public static function getAllContent($count)
    {
        $data = Requester::where('requester_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
