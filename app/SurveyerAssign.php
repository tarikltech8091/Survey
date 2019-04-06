<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyerAssign extends Model
{
    
    protected $table='surveyer_assign_tbl';

    protected $fillable = [
        'assign_surveyer_id',
        'assign_surveyer_name',
        'assign_campaign_id',
        'assign_campaign_name',
        'surveyer_prize_amount',
        'validate_refference',
        'assign_campaign_complain',
        'assign_campaign_description',
        'assign_status',
        'assign_created_by',
        'assign_updated_by'
    ];

    /**
     * get all content.
     *
     * @param int $count
     * @return mixed
     */
    public static function getAllContent($count)
    {
        $data = SurveyerAssign::where('assign_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
