<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    
    protected $table='zone_tbl';

    protected $fillable = [
        'zone_name',
        'zone_name_slug',
        'zone_zip_code',
        'zone_district',
        'zone_upzilla',
        'zone_address_details',
        'zone_status',
        'zone_created_by',
        'zone_updated_by'
    ];
}
