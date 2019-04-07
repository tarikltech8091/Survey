<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EarnPaid extends Model
{
    
    protected $table='earn_paid_tbl';

    protected $fillable = [
        'earn_paid_user_type',
        'earn_paid_surveyer_id',
        'earn_paid_surveyer_mobile',
        'earn_paid_participate_id',
        'earn_paid_participate_mobile',
        'earn_paid_date',
        'earn_paid_payment_type',
        'earn_paid_amount',
        'payment_transaction_id',
        'earn_paid_description',
        'earn_paid_status',
        'earn_paid_created_by',
        'earn_paid_updated_by'
    ];

    /**
     * get all content.
     *
     * @param int $count
     * @return mixed
     */
    public static function getAllContent($count)
    {
        $data = EarnPaid::where('earn_paid_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
