<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $table='category_tbl';

    protected $fillable = [
        'category_name',
        'category_name_slug',
        'category_status',
        'category_created_by',
        'category_updated_by'
    ];
    
}
