<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignPayment extends Model
{
    
    protected $table='campaign_payment_history_tbl';

    protected $fillable = [
        'payment_campaign_id',
        'payment_campaign_name',
        'payment_requester_id',
        'payment_date',
        'payment_type',
        'payment_amount',
        'earn_date',
        'payment_transaction_id',
        'payment_status',
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
        $data = CampaignPayment::where('payment_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
