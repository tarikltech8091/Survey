<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    
    protected $table='question_tbl';

    protected $fillable = [
        'question_campaign_name',
        'question_campaign_id',
        'question_type',
        'question_position',
        'question_title',
        'question_option_1',
        'question_option_2',
        'question_option_3',
        'question_option_4',
        'question_option_new',
        'question_image',
        'question_video',
        'question_special',
        'question_points',
        'question_published_date',
        'question_published_status',
        'question_status',
        'question_created_by',
        'question_updated_by'
    ];

    /**
     * get all content.
     *
     * @param int $count
     * @return mixed
     */
    public static function getAllContent($count)
    {
        $data = Question::where('question_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
