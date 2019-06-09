<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppToken extends Model
{
    
    protected $table='app_token_tbl';

    protected $fillable = [
        'imei_no',
        'app_key',
        'access_token',
        'client_ip',
        'access_browser',
        'access_city',
        'access_division',
        'access_country',
        'referenceCode',
        'token_status'
    ];


}
