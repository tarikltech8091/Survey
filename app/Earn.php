<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Earn extends Model
{
    
    protected $table='earn_tbl';

    protected $fillable = [
        'earn_user_type',
        'earn_type',
        'earn_surveyer_or_participate_id',
        'earn_mobile_number',
        'earn_campaign_id',
        'earn_campaign_name',
        'earn_date',
        'earn_amount',
        'earn_status',
        'earn_created_by',
        'earn_updated_by'
    ];
    
    /**
     * get all content.
     *
     * @param int $count
     * @return mixed
     */
    public static function getAllContent($count)
    {
        $data = Earn::where('earn_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
