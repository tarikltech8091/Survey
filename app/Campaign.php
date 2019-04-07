<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    
    protected $table='campaign_tbl';

    protected $fillable = [
        'campaign_name',
        'campaign_name_slug',
        'campaign_category',
        'campaign_title',
        'campaign_requester_name',
        'campaign_requester_id',
        'campaign_requester_mobile',
        'campaign_create_date',
        'campaign_start_date',
        'campaign_end_date',
        'campaign_num_of_days',
        'campaign_unique_code',
        'campaign_total_cost',
        'campaign_total_cost_paid',
        'campaign_cost_for_surveyer',
        'campaign_prize_amount',
        'campaign_physical_prize',
        'campaign_zone',
        'campaign_total_num_of_zone',
        'campaign_image',
        'campaign_description',
        'campaign_published_status',
        'campaign_payment_status',
        'campaign_status',
        'campaign_created_by',
        'campaign_updated_by'
    ];

    /**
     * get all content.
     *
     * @param int $count
     * @return mixed
     */
    public static function getAllContent($count)
    {
        $data = Campaign::where('campaign_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
