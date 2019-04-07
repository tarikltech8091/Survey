<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    
    protected $table='question_answer_tbl';

    protected $fillable = [
        'campaign_id',
        'question_id',
        'participate_id',
        'participate_mobile',
        'question_answer_type',
        'question_title',
        'question_answer_option_1',
        'question_answer_option_2',
        'question_answer_option_3',
        'question_answer_option_4',
        'question_answer_text_value',
        'question_answer_validate_type',
        'question_answer_validate',
        'question_answer_status',
        'question_answer_created_by',
        'question_answer_updated_by'
    ];


    /**
     * get all content.
     *
     * @param int $count
     * @return mixed
     */
    public static function getAllContent($count)
    {
        $data = QuestionAnswer::where('question_answer_status',1)
            ->orderBy('id','desc')
            ->paginate($count);
        return $data;
    }
}
