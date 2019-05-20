<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Db;


class QuestionAnswerController extends Controller
{

    /**
     * Class constructor.
     * get current route name for page title
     *
     * @param Request $request;
     */
    public function __construct(Request $request)
    {
        $this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ?  $description['desc']:$this->page_title;
        // \App\System::AccessLogWrite();
    }


    /********************************************
    ## Show the list of all Content
     *********************************************/
    public function getAllContentCountdown()
    {
        if(isset($_GET['search_campaign_id'])){

            $total_participate =  \App\CampaignParticipate::where(function($query){
                if(isset($_GET['search_campaign_id'])){
                    $query->where(function ($q){
                        $q->where('participate_campaign_id', $_GET['search_campaign_id']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->count();

            $data['total_participate'] = $total_participate;


            $numberOfQuestions = \DB::table('question_answer_tbl')->where('answer_campaign_id', $_GET['search_campaign_id'])->select('answer_question_id','question_answer_title',DB::raw('count(*) as num'))->groupBy('answer_question_id','question_answer_title')->get();
            $data['numberOfQuestions'] = $numberOfQuestions;


            $all_content =  \App\QuestionAnswer::where(function($query){
                if(isset($_GET['search_campaign_id'])){
                    $query->where(function ($q){
                        $q->where('answer_campaign_id', $_GET['search_campaign_id']);
                    });
                }
            })
                ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_answer_tbl.answer_campaign_id')
                ->join('question_tbl', 'question_tbl.id', '=', 'question_answer_tbl.answer_question_id')
                ->orderBy('question_answer_tbl.id','DESC')
                ->select('question_answer_tbl.id AS question_answer_id', 'campaign_tbl.*' , 'question_tbl.*', 'question_answer_tbl.*')
                ->paginate(20);

            $search_campaign_id = isset($_GET['search_campaign_id'])? $_GET['search_campaign_id']:0;

            $all_content->setPath(url('/admin/campaign/participate/countdown'));
            $pagination = $all_content->appends(['answer_campaign_id' => $search_campaign_id])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{

            /*$total_participate =  \App\CampaignParticipate::orderBy('id','DESC')->count();
            $data['total_participate'] = $total_participate;

            $numberOfQuestions = \DB::table('question_answer_tbl')->select('answer_question_id','question_answer_title',DB::raw('count(*) as num'))->groupBy('answer_question_id','question_answer_title')->get();
            $data['numberOfQuestions'] = $numberOfQuestions;


            $all_content= \DB::table('question_answer_tbl')
                ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_answer_tbl.answer_campaign_id')
                ->join('question_tbl', 'question_tbl.id', '=', 'question_answer_tbl.answer_question_id')
                ->orderBy('question_answer_tbl.id','DESC')
                ->select('question_answer_tbl.id AS question_answer_id', 'campaign_tbl.*' , 'question_tbl.*', 'question_answer_tbl.*')
                ->paginate(20);
            $all_content->setPath(url('/campaign/participate/countdown'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;*/

        }

        $data['all_campaign'] =  \App\Campaign::orderby('id','desc')->get();

        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question-answer.countdown',$data);
    }


    /********************************************
    ## Show the list of all single question Answer
     *********************************************/
    public function getAllSingleQuestionAnswer($answer_question_id)
    {

        $total_content= \DB::table('question_answer_tbl')
            ->where('answer_question_id',$answer_question_id)->count();
        $data['total_content'] = $total_content;

        $question_answer_option_1 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_1','!=', '')->count();
        $data['question_answer_option_1'] = $question_answer_option_1;

        $question_answer_option_2 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_2','!=', '')->count();
        $data['question_answer_option_2'] = $question_answer_option_2;


        $question_answer_option_3 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_3','!=', '')->count();
        $data['question_answer_option_3'] = $question_answer_option_3;


        $question_answer_option_4 = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_option_4','!=', '')->count();
        $data['question_answer_option_4'] = $question_answer_option_4;


        $question_answer_text_value = \DB::table('question_answer_tbl')->where('answer_question_id', $answer_question_id)->where('question_answer_text_value','!=', '')->count();
        $data['question_answer_text_value'] = $question_answer_text_value;

        $all_content= \DB::table('question_answer_tbl')
            ->where('answer_question_id',$answer_question_id)
            ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_answer_tbl.answer_campaign_id')
            ->join('question_tbl', 'question_tbl.id', '=', 'question_answer_tbl.answer_question_id')
            ->orderBy('question_answer_tbl.id','DESC')
            ->select('question_answer_tbl.id AS question_answer_id', 'campaign_tbl.*' , 'question_tbl.*', 'question_answer_tbl.*')
            ->paginate(20);
        $all_content->setPath(url('/admin/campaign/participate/countdown'));
        $pagination = $all_content->render();
        $data['perPage'] = $all_content->perPage();
        $data['pagination'] = $pagination;
        $data['all_content'] = $all_content;

        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question-answer.question-details',$data);
    }






    /********************************************
    ## Show the list of all Campaign
     *********************************************/
    public function getAllCampaign()
    {

        $all_content= \App\Campaign::where('campaign_status',1)->orderBy('id','DESC')->get();

        $data['all_content'] = $all_content;
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question-answer.campaign-list',$data);
    }

    /********************************************
    ## Show the list of all Content
     *********************************************/
    public function getAllContent()
    {
        if(isset($_GET['question_answer_status'])){
            $all_content =  \DB::table('question_answer_tbl')->where(function($query){
                if(isset($_GET['question_answer_status']) && ($_GET['question_answer_status'] != 22)){
                    $query->where(function ($q){
                        $q->where('question_answer_status', $_GET['question_answer_status']);
                    });
                }
                if(isset($_GET['answer_campaign_id']) && $_GET['answer_campaign_id'] != 0){
                    $query->where(function ($q){
                        $q->where('answer_campaign_id', $_GET['answer_campaign_id']);
                    });
                }

                if(isset($_GET['answer_surveyer_id']) && $_GET['answer_surveyer_id'] != 0){
                    $query->where(function ($q){
                        $q->where('answer_surveyer_id', $_GET['answer_surveyer_id']);
                    });
                }
            })
                ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_answer_tbl.answer_campaign_id')
                ->join('surveyer_tbl', 'surveyer_tbl.id', '=', 'question_answer_tbl.answer_surveyer_id')
                ->join('question_tbl', 'question_tbl.id', '=', 'question_answer_tbl.answer_question_id')
                ->orderBy('question_answer_tbl.id','DESC')
                ->select('question_answer_tbl.id AS question_answer_id', 'campaign_tbl.*', 'surveyer_tbl.*', 'question_tbl.*', 'question_answer_tbl.*')
                ->paginate(20);

            $question_answer_status = isset($_GET['question_answer_status'])? $_GET['question_answer_status']:0;
            $answer_campaign_id = isset($_GET['answer_campaign_id'])? $_GET['answer_campaign_id']:0;
            $answer_surveyer_id = isset($_GET['answer_surveyer_id'])? $_GET['answer_surveyer_id']:0;

            $all_content->setPath(url('/questions/answer/list'));
            $pagination = $all_content->appends(['question_answer_status' => $question_answer_status, 'answer_campaign_id' => $answer_campaign_id, 'answer_surveyer_id' => $answer_surveyer_id])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('question_answer_tbl')
                            ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_answer_tbl.answer_campaign_id')
                            ->join('surveyer_tbl', 'surveyer_tbl.id', '=', 'question_answer_tbl.answer_surveyer_id')
                            ->join('question_tbl', 'question_tbl.id', '=', 'question_answer_tbl.answer_question_id')
                            ->orderBy('question_answer_tbl.id','DESC')
                            ->select('question_answer_tbl.id AS question_answer_id', 'campaign_tbl.*', 'surveyer_tbl.*', 'question_tbl.*', 'question_answer_tbl.*')
                            ->paginate(20);
            $all_content->setPath(url('/questions/answer/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_campaign'] = \DB::table('campaign_tbl')->where('campaign_status','1')->orderby('id','desc')->get();
        $data['all_surveyer'] = \DB::table('surveyer_tbl')->where('surveyer_status','1')->orderby('id','desc')->get();

        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question-answer.index',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {
        $data['all_campaign'] = \DB::table('campaign_tbl')->where('campaign_status','1')->orderby('id','desc')->get();
        $data['all_zone']=\App\Zone::where('zone_status',1)->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question-answer.create',$data);
    }

    /********************************************
    ##  FirstQuestionAnswer View
     *********************************************/
    public function FirstQuestionAnswer($surveyer_id, $campaign_id, $question_position)
    {
        $data['select_surveyer'] = \DB::table('surveyer_tbl')->where('id',$surveyer_id)->where('surveyer_status','1')->orderby('id','desc')->first();
        $data['select_campaign'] = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();
        $data['select_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();
        $data['all_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();
        $data['all_district']=\App\Common::AllDistrict();
        $data['all_zone']=\App\Zone::where('zone_status',1)->get();
        $data['surveyer_id'] = $surveyer_id;
        $data['campaign_id'] = $campaign_id;
        $data['question_position'] = $question_position;
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question-answer.create',$data);
    }


    /********************************************
    ##  QuestionAnswer View
     *********************************************/
    public function QuestionAnswer($campaign_participate_mobile, $surveyer_id, $campaign_id, $question_position)
    {
        $data['select_surveyer'] = \DB::table('surveyer_tbl')->where('id',$surveyer_id)->where('surveyer_status','1')->orderby('id','desc')->first();
        $data['select_campaign'] = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();
        $data['select_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();
        $data['all_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();
        $total_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->select(DB::raw('count(*) as user_count'))->get();

        $data['all_district']=\App\Common::AllDistrict();
        $data['all_zone']=\App\Zone::where('zone_status',1)->get();
        $data['campaign_participate_mobile'] = $campaign_participate_mobile;
        $data['surveyer_id'] = $surveyer_id;
        $data['campaign_id'] = $campaign_id;
        $data['question_position'] = $question_position;
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question-answer.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request, $surveyer_id, $campaign_id, $question_position)
    {

        $v = \Validator::make($request->all(), [
            'participate_name' => 'required',
            'participate_email' => 'required|email',
            'participate_mobile' => 'Required|regex:/^[^0-9]*(88)?0/|max:11',
            'participate_age' => 'required',
            'participate_join_date' => 'required',
            'participate_district' => 'required',
            'participate_post_code' => 'required',
            'participate_address' => 'required',
            'participate_nid' => 'required',
            'participate_gender' => 'required',
            'participate_religion' => 'required',
            'participate_occupation' => 'required',
        ]);


        if($v->passes()){


            try{

                $participate_mobile=$request->input('participate_mobile');
                $question_position = $request->input('answer_question_position');
                $question_next_position = $question_position + 1;

                $success = \DB::transaction(function () use($request) {

                    $surveyer_id = $request->input('answer_surveyer_id');
                    $campaign_id = $request->input('answer_campaign_id');
                    $question_position = $request->input('answer_question_position');
                    $question_next_position = $question_position + 1;
                    $participate_mobile=$request->input('participate_mobile');


                    $select_surveyer = \DB::table('surveyer_tbl')->where('id',$surveyer_id)->where('surveyer_status','1')->orderby('id','desc')->first();
                    $select_campaign = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();
                    $select_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();
                    $all_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();


                    if(isset($select_question) && (($select_question->question_position) == 1)){

                        $question_id = $select_question->id;

                        $participate_profile_image='';
                        $image_type='participate';

                        $participate_name=$request->input('participate_name');
                        $slug=explode(' ', strtolower($request->input('participate_name')));
                        $participate_name_slug=implode('-', $slug);
                        $data['participate_name_slug']=$participate_name_slug;

                        if($request->file('participate_profile_image')!=null){
                            #ImageUpload
                            $image_wide = $request->file('participate_profile_image');
                            $img_location_wide=$image_wide->getRealPath();
                            $img_ext_wide=$image_wide->getClientOriginalExtension();
                            $participate_profile_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$participate_name);
                        }

                        $data['participate_name']=$request->input('participate_name');
                        $data['participate_name_slug']=$request->input('participate_name_slug');
                        $data['participate_email']=$request->input('participate_email');
                        $data['participate_mobile']=$request->input('participate_mobile');
                        $data['participate_age']=$request->input('participate_age');
                        $data['participate_join_date']=$request->input('participate_join_date');
                        $data['participate_district']=$request->input('participate_district');
                        $data['participate_post_code']=$request->input('participate_post_code');
                        $data['participate_address']=$request->input('participate_address');
                        $data['participate_nid']=$request->input('participate_nid');
                        $data['participate_gender']=$request->input('participate_gender');
                        $data['participate_religion']=$request->input('participate_religion');
                        $data['participate_occupation']=$request->input('participate_occupation');
                        $data['participate_zone']=$request->input('participate_zone');
                        $data['agreed_user']=0;
                        $data['participate_profile_image']=$participate_profile_image;
                        $data['participate_created_by'] = \Auth::user()->id;
                        $data['participate_updated_by'] = \Auth::user()->id;



                        $campaign_participate_data['participate_campaign_id']=$campaign_id;
                        $campaign_participate_data['participate_campaign_name']=$select_campaign->campaign_name;
                        $campaign_participate_data['campaign_participate_mobile']=$request->input('participate_mobile');
                        $campaign_participate_data['campaign_participate_occupation']=$request->input('participate_occupation');
                        $campaign_participate_data['campaign_participate_age']=$request->input('participate_age');
                        $campaign_participate_data['campaign_participate_district']=$request->input('participate_district');
                        $campaign_participate_data['campaign_participate_post_code']=$request->input('participate_post_code');
                        $campaign_participate_data['campaign_participate_zone']=$request->input('participate_zone');
                        $campaign_participate_data['campaign_participate_address']=$request->input('participate_address');
                        $campaign_participate_data['participate_prize_amount']=$request->input('participate_prize_amount');
                        $campaign_participate_data['campaign_participate_status']=1;
                        $campaign_participate_data['campaign_participate_created_by'] = \Auth::user()->id;
                        $campaign_participate_data['campaign_participate_updated_by'] = \Auth::user()->id;


                        $participate_insertOrUpdate = \App\Participate::updateOrCreate(
                            [
                                'participate_mobile' => $data['participate_mobile'],
                            ],
                            $data
                        );


                        $campaign_participate_info = \DB::table('campaign_participate_tbl')->where('participate_campaign_id',$campaign_id)->where('campaign_participate_mobile',$request->input('participate_mobile'))->first();

                        if(!empty($campaign_participate_info)){

                            $campaign_participate_insertOrUpdate=\DB::table('campaign_participate_tbl')->where('id',$campaign_participate_info->id)->update($campaign_participate_data);

                        }else{

                            $campaign_participate_insertOrUpdate=\DB::table('campaign_participate_tbl')->insert($campaign_participate_data);

                        }


                        // $campaign_participate_insert = \App\CampaignParticipate::updateOrCreate (
                        //     [
                        //         'participate_campaign_id' => $campaign_id,
                        //         'campaign_participate_mobile' => $data['participate_mobile'],

                        //     ],
                        //     $campaign_participate_data
                        // );

                    }

                    $question_answer_data['answer_surveyer_id']=$surveyer_id;
                    $question_answer_data['answer_campaign_id']=$campaign_id;
                    $question_answer_data['answer_question_id']=$question_id;
                    $question_answer_data['answer_participate_mobile']=$request->input('participate_mobile');
                    // $question_answer_data['question_answer_type']=$request->input('question_answer_type');
                    $question_answer_data['question_answer_type']='easy';
                    $question_answer_data['question_answer_title']=$request->input('question_answer_title');
                    $question_answer_data['question_answer_option_1']=$request->input('question_option_1');
                    $question_answer_data['question_answer_option_2']=$request->input('question_option_2');
                    $question_answer_data['question_answer_option_3']=$request->input('question_option_3');
                    $question_answer_data['question_answer_option_4']=$request->input('question_option_4');
                    $question_answer_data['question_answer_text_value']=$request->input('question_option_new');
                    $question_answer_data['question_answer_status']=0;
                    $question_answer_data['question_answer_created_by'] = \Auth::user()->id;
                    $question_answer_data['question_answer_updated_by'] = \Auth::user()->id;

                    $question_answer_info = \DB::table('question_answer_tbl')->where('answer_question_id',$question_id)->where('answer_campaign_id',$campaign_id)->where('answer_participate_mobile',$request->input('participate_mobile'))->first();

                    if(!empty($question_answer_info)){

                        $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->where('id',$question_answer_info->id)->update($question_answer_data);

                    }else{

                        $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->insert($question_answer_data);

                    }

                   
                    // $question_answer_insert = \App\QuestionAnswer::updateOrCreate(
                    //     [
                    //         'answer_participate_mobile' => $question_answer_data['answer_participate_mobile'],
                    //         'answer_question_id' => $question_id,
                    //     ],
                    //     $question_answer_data
                    // );



                    if(!$participate_insertOrUpdate || !$campaign_participate_insertOrUpdate || !$question_answer_insertOrUpdate){
                        $error=1;
                    }


                    if(!isset($error)){
                        // \App\System::EventLogWrite('insert,participate_tbl',json_encode($data));
                        // \App\System::EventLogWrite('insert,campaign_participate_tbl',json_encode($campaign_participate_data));
                        // \App\System::EventLogWrite('insert,question_answer_tbl',json_encode($question_answer_data));
                        \DB::commit();

                        
                    }else{
                        \DB::rollback();
                        throw new Exception("Error Processing Request", 1);
                    }



                });

                return redirect()->to('/all/question/answer/'.$participate_mobile.'/'.$surveyer_id.'/'.$campaign_id.'/'.$question_next_position)->with('message','Question Answer Successfully');




            }catch (\Exception $e){
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in questions Upload');
            }

        } else{
            return redirect()->back()->withErrors($v)->withInput();
        }
    }




    /********************************************
    ##  QuestionAnswerStore
     *********************************************/
    public function QuestionAnswerStore(Request $request, $surveyer_id, $campaign_id, $question_position)
    {

        $v = \Validator::make($request->all(), [
            /*'participate_mobile' => 'required',
            'question_title' => 'required',
            'question_type' => 'required',
            'question_campaign_name' => 'required',
            'question_campaign_id' => 'required',
            'question_position' => 'required',
            'question_special' => 'required',
            'question_option_1' => 'required',
            'question_option_2' => 'required',
            'question_option_3' => 'required',
            'question_points' => 'required',*/
        ]);


        if($v->passes()){

            try{
            
                $surveyer_id = $request->input('answer_surveyer_id');
                $campaign_id = $request->input('answer_campaign_id');
                $question_position = $request->input('answer_question_position');
                $question_next_position = $question_position + 1;
                $next_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_next_position)->where('question_status','1')->orderby('id','desc')->first();
                $total_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->select(DB::raw('count(*) as user_count'))->get();

                $participate_mobile = $request->input('campaign_participate_mobile');

                $success = \DB::transaction(function () use($request) {

                    $surveyer_id = $request->input('answer_surveyer_id');
                    $campaign_id = $request->input('answer_campaign_id');
                    $question_position = $request->input('answer_question_position');
                    $participate_mobile = $request->input('campaign_participate_mobile');

                    $select_surveyer = \DB::table('surveyer_tbl')->where('id',$surveyer_id)->where('surveyer_status','1')->orderby('id','desc')->first();
                    $select_campaign = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();
                    $select_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();
                    $all_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();

                    $question_id = $select_question->id;


                    if($question_position != 1){


                        $question_answer_data['answer_campaign_id']=$campaign_id;
                        $question_answer_data['answer_surveyer_id']=$surveyer_id;
                        $question_answer_data['answer_question_id']=$question_id;
                        $question_answer_data['answer_participate_mobile']=$request->input('campaign_participate_mobile');
                        // $question_answer_data['question_answer_type']=$request->input('question_answer_type');
                        $question_answer_data['question_answer_type']='easy';
                        $question_answer_data['question_answer_title']=$request->input('question_answer_title');
                        $question_answer_data['question_answer_option_1']=$request->input('question_option_1');
                        $question_answer_data['question_answer_option_2']=$request->input('question_option_2');
                        $question_answer_data['question_answer_option_3']=$request->input('question_option_3');
                        $question_answer_data['question_answer_option_4']=$request->input('question_option_4');
                        $question_answer_data['question_answer_text_value']=$request->input('question_option_new');
                        $question_answer_data['question_answer_status']=0;
                        $question_answer_data['question_answer_created_by'] = \Auth::user()->id;
                        $question_answer_data['question_answer_updated_by'] = \Auth::user()->id;

                        $question_answer_info = \DB::table('question_answer_tbl')->where('answer_question_id',$question_id)->where('answer_campaign_id',$campaign_id)->where('answer_participate_mobile',$participate_mobile)->first();
                        
                        if(!empty($question_answer_info)){

                            $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->where('id',$question_answer_info->id)->update($question_answer_data);

                        }else{

                            $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->insert($question_answer_data);

                        }

                       
                        // $question_answer_insert = \App\QuestionAnswer::updateOrCreate(
                        //     [
                        //         'answer_participate_mobile' => $question_answer_data['answer_participate_mobile'],
                        //         'answer_question_id' => $question_id,
                        //     ],
                        //     $question_answer_data
                        // );


                        if(!$question_answer_insertOrUpdate){
                            $error=1;
                        }

                        if(!isset($error)){
                            // \App\System::EventLogWrite('insert,question_answer_tbl',json_encode($question_answer_data));
                            \DB::commit();
                            
                        }else{
                            \DB::rollback();
                            throw new Exception("Error Processing Request", 1);
                        }

                        // return redirect()->back()->with('message','Question Created Successfully');

                    }else{
                        return redirect()->to('/question/answer/'.$surveyer_id.'/'.$campaign_id.'/1')->with('message','First Question Answer');
                     }

                });

                if(!empty($next_question) && $total_question >= $question_next_position){
                    return redirect()->to('/all/question/answer/'.$participate_mobile.'/'.$surveyer_id.'/'.$campaign_id.'/'. $question_next_position)->with('message','Question Answer Successfully');
                }else{
                    return redirect()->to('/participate/campaign/list/')->with('message','Camapaign Participate Successfully');
                }


            }catch (\Exception $e){
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in questions Upload');
            }
        } else{
            return redirect()->back()->withErrors($v)->withInput();
        }
    }



    /********************************************
    ## Change publish status for individual.
     *********************************************/
    public function ChangePublishStatus($id, $status)
    {
        //check if this questions has any content published or not
        $content_exists =\DB::table('question_answer_tbl')->where('id',$id)->first();
        if(!empty($content_exists))
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['question_answer_status']=1;
            } else{
                $data['question_answer_status']=0;
            }
            $update=\DB::table('question_answer_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,question_answer_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,question_answer_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this questions. Please upload and publish any content to publish this content.';
        }

    }


    /********************************************
    ## Change validate status for individual.
     *********************************************/
    public function ChangeValidateStatus($id, $status)
    {
        //check if this questions has any content Validate or not
        $content_exists =\DB::table('question_answer_tbl')->where('id',$id)->first();
        if(!empty($content_exists))
        {
            $now = date('Y-m-d H:i:s');
            if($status=='yes'){
                $data['question_answer_validate']='yes';
            } else{
                $data['question_answer_validate']='no';
            }
            $update=\DB::table('question_answer_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Validate updated successfully.';
                // \App\System::EventLogWrite('update,question_answer_validate|Validate updated successfully.',$id);
            } else {
                echo 'Validate did not update.';
                // \App\System::EventLogWrite('update,question_answer_validate|Validate did not updated.',$id);
            }
        } else{
            echo 'There is no validate content for this questions. Please upload and validate any content to validate this content.';
        }

    }


    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['edit'] = \DB::table('question_tbl')->where('id', $id)->first();
        $data['all_zone']=\App\Zone::where('zone_status',1)->get();
        $data['all_campaign'] = \DB::table('campaign_tbl')->where('campaign_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question-answer.edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'question_title' => 'required',
            'question_type' => 'required',
            'question_campaign_name' => 'required',
            'question_campaign_id' => 'required',
            'question_position' => 'required',
            'question_special' => 'required',
            'question_option_1' => 'required',
            'question_option_2' => 'required',
            'question_option_3' => 'required',
            'question_points' => 'required',
        ]);

        if($v->passes()){

            try
            {

                $question_data= \DB::table('question_tbl')->where('id', $id)->first();

                $data['question_title']=$request->input('question_title');
                $data['question_type']=$request->input('question_type');
                $data['question_campaign_name']=$request->input('question_campaign_name');
                $data['question_campaign_id']=$request->input('question_campaign_id');
                $data['question_position']=$request->input('question_position');
                $data['question_special']=$request->input('question_special');
                $data['question_option_1']=$request->input('question_option_1');
                $data['question_option_2']=$request->input('question_option_2');
                $data['question_option_3']=$request->input('question_option_3');
                $data['question_option_4']=$request->input('question_option_4');
                $data['question_option_new']=$request->input('question_option_new');
                $data['question_points']=$request->input('question_points');
                // $data['question_published_date']='';
                $data['question_updated_by'] = \Auth::user()->id;

                $update=\DB::table('question_tbl')->where('id', $id)->update($data);

                // \App\System::EventLogWrite('update,question_tbl',json_encode($data));

                return redirect()->back()->with('message','Content Updated Successfully !!');

            }catch (\Exception $e){

                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                // \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in Content Update !!');
            }
        }else return redirect()->back()->withErrors($v)->withInput();
    }

    /********************************************
    ## Delete
     *********************************************/
    public function Delete($id)
    {
        $delete = \DB::table('question_tbl')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,question_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,question_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }





    /********************************************
    ##  ParticipateQuestionAnswer View
     *********************************************/
    public function ParticipateQuestionAnswer($campaign_participate_mobile, $campaign_id, $question_position)
    {

        $data['select_campaign'] = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();
        $data['select_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();
        $data['all_question'] = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();
        $total_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->select(DB::raw('count(*) as user_count'))->get();

        $data['all_district']=\App\Common::AllDistrict();
        $data['all_zone']=\App\Zone::where('zone_status',1)->get();
        $data['campaign_participate_mobile'] = $campaign_participate_mobile;
        $data['campaign_id'] = $campaign_id;
        $data['question_position'] = $question_position;
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question-answer.participate-question-answer',$data);
    }

    /********************************************
    ##  ParticipateQuestionAnswerStore
     *********************************************/
    public function ParticipateQuestionAnswerStore(Request $request, $campaign_id, $question_position)
    {

        $v = \Validator::make($request->all(), [
            /*'participate_name' => 'required',
            'participate_email' => 'required|email',
            'participate_mobile' => 'Required|regex:/^[^0-9]*(88)?0/|max:11',
            'participate_age' => 'required',
            'participate_join_date' => 'required',
            'participate_district' => 'required',
            'participate_post_code' => 'required',
            'participate_address' => 'required',
            'participate_nid' => 'required',
            'participate_gender' => 'required',
            'participate_religion' => 'required',
            'participate_occupation' => 'required',*/
        ]);


        if($v->passes()){


            try{

                $answer_campaign_id=$request->input('answer_campaign_id');
                $campaign_participate_mobile=$request->input('campaign_participate_mobile');
                $answer_question_position = $request->input('answer_question_position');
                $question_next_position = $answer_question_position + 1;


                $next_question = \DB::table('question_tbl')->where('question_campaign_id',$answer_campaign_id)->where('question_position',$question_next_position)->where('question_status','1')->orderby('id','desc')->first();

                $total_question = \DB::table('question_tbl')->where('question_campaign_id',$answer_campaign_id)->where('question_status','1')->select(DB::raw('count(*) as user_count'))->get();



                $success = \DB::transaction(function () use($request, $campaign_participate_mobile, $answer_question_position, $question_next_position, $next_question, $total_question) {

                    if(!empty(\Auth::user()->surveyer_id)){
                        $surveyer_id = \Auth::user()->surveyer_id;
                    }else{
                        $surveyer_id ='';
                    }

                    $campaign_id = $request->input('answer_campaign_id');
                    $question_position = $request->input('answer_question_position');
                    $question_next_position = $question_position + 1;
                    $participate_mobile=$request->input('campaign_participate_mobile');


                    $select_participate = \DB::table('participate_tbl')->where('participate_mobile',$campaign_participate_mobile)->first();

                    $select_campaign = \DB::table('campaign_tbl')->where('id',$campaign_id)->where('campaign_status','1')->orderby('id','desc')->first();
                    $select_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_position',$question_position)->where('question_status','1')->orderby('id','desc')->first();
                    $question_id = $select_question->id;

                    $all_question = \DB::table('question_tbl')->where('question_campaign_id',$campaign_id)->where('question_status','1')->orderby('id','desc')->get();


                    if(isset($select_question) && (($select_question->question_position) == 1)){

                        $question_id = $select_question->id;


                        $campaign_participate_data['participate_campaign_id']=$campaign_id;
                        $campaign_participate_data['participate_campaign_name']=$select_campaign->campaign_name;
                        $campaign_participate_data['campaign_participate_mobile']=$campaign_participate_mobile;
                        $campaign_participate_data['campaign_participate_occupation']=$select_participate->participate_occupation;
                        $campaign_participate_data['campaign_participate_age']=$select_participate->participate_age;
                        $campaign_participate_data['campaign_participate_district']=$select_participate->participate_district;
                        $campaign_participate_data['campaign_participate_post_code']=$select_participate->participate_post_code;
                        $campaign_participate_data['campaign_participate_zone']=$select_participate->participate_zone;
                        $campaign_participate_data['campaign_participate_address']=$select_participate->participate_address;
                        $campaign_participate_data['participate_prize_amount']=$request->input('participate_prize_amount');
                        $campaign_participate_data['campaign_participate_status']=1;
                        // $campaign_participate_data['campaign_participate_created_by'] = \Auth::user()->id;
                        // $campaign_participate_data['campaign_participate_updated_by'] = \Auth::user()->id;




                        $campaign_participate_info = \DB::table('campaign_participate_tbl')->where('participate_campaign_id',$campaign_id)->where('campaign_participate_mobile',$campaign_participate_mobile)->first();

                        if(!empty($campaign_participate_info)){

                            $campaign_participate_insertOrUpdate=\DB::table('campaign_participate_tbl')->where('id',$campaign_participate_info->id)->update($campaign_participate_data);

                        }else{

                            $campaign_participate_insertOrUpdate=\DB::table('campaign_participate_tbl')->insert($campaign_participate_data);

                        }

                        if(!$campaign_participate_insertOrUpdate){
                            $error=1;
                        }

                        if(!isset($error)){
                            \App\System::EventLogWrite('insert,campaign_participate_tbl',json_encode($campaign_participate_data));
                        }


                    }

                    if(!empty(\Auth::user()->surveyer_id)){
                        $question_answer_data['answer_surveyer_id']=\Auth::user()->surveyer_id;
                    }

                    $question_answer_data['answer_campaign_id']=$campaign_id;
                    $question_answer_data['answer_question_id']=$question_id;
                    $question_answer_data['answer_participate_mobile']=$campaign_participate_mobile;
                    $question_answer_data['question_answer_type']=$select_question->question_type;
                    $question_answer_data['question_answer_title']=$request->input('question_answer_title');
                    $question_answer_data['question_answer_option_1']=$request->input('question_option_1');
                    $question_answer_data['question_answer_option_2']=$request->input('question_option_2');
                    $question_answer_data['question_answer_option_3']=$request->input('question_option_3');
                    $question_answer_data['question_answer_option_4']=$request->input('question_option_4');
                    $question_answer_data['question_answer_text_value']=$request->input('question_option_new');
                    $question_answer_data['question_answer_status']=0;
                    // $question_answer_data['question_answer_created_by'] = \Auth::user()->id;
                    // $question_answer_data['question_answer_updated_by'] = \Auth::user()->id;

                    $question_answer_info = \DB::table('question_answer_tbl')->where('answer_question_id',$question_id)->where('answer_campaign_id',$campaign_id)->where('answer_participate_mobile',$campaign_participate_mobile)->first();

                    if(!empty($question_answer_info)){

                        $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->where('id',$question_answer_info->id)->update($question_answer_data);

                    }else{

                        $question_answer_insertOrUpdate=\DB::table('question_answer_tbl')->insert($question_answer_data);

                    }



                    if(!$question_answer_insertOrUpdate){
                        $error=1;
                    }


                    if(!isset($error)){

                        // \App\System::EventLogWrite('insert,question_answer_tbl',json_encode($question_answer_data));
                        \DB::commit();

                        
                    }else{
                        \DB::rollback();
                        throw new Exception("Error Processing Request", 1);
                    }



                });



                if(!empty($next_question)){

                    return redirect()->to('/participate/question/answer/'.$campaign_participate_mobile.'/'.$answer_campaign_id.'/'.$question_next_position)->with('message','Question Answer Successfully');

                }else{
                    return redirect()->to('/participate/campaign/list/')->with('message','Camapaign Participate Successfully');
                }

                

            }catch (\Exception $e){
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in questions Upload');
            }

        } else{
            return redirect()->back()->withErrors($v)->withInput();
        }
    }











}
