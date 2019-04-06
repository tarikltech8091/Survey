<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignFeedback extends Model
{
    
    protected $table='campaign_feedback_tbl';

    protected $fillable = [
        'feedback_question_id',
        'feedback_campaign_id',
        'feedback_user_type',
        'feedback_mobile_number',
        'feedback_district',
        'feedback_zone',
        'feedback_post_code',
        'feedback_description',
        'feedback_status',
        'is_true',
        'feedback_created_by',
        'feedback_updated_by'
    ];
    
    /**
     * get all content.
     *
     * @param int $count
     * @return mixed
     */
    public static function getAllContent($count)
    {
        $data = CampaignFeedback::where('feedback_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
