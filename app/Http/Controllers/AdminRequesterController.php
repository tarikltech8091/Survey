<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requester;
use App\Campaign;
use DB;

class AdminRequesterController extends Controller
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


    public function Dashboard()
    {

        $data['page_title'] = $this->page_title;
        return view('pages.admin-requester.index',$data);
    }
    

    public function index()
    {
        $data['page_title'] = $this->page_title;
        return view('admin.index', $data);
    }
    /**
     * Display profile information
     * pass page title
     * Get User data by auth email
     * Get User meta data by joining user
     * Get Products by auth user.
     *
     * @return HTML view Response.
     */
    public function Profile()
    {

        $data['page_title'] = $this->page_title;

        if (isset($_REQUEST['tab']) && !empty($_REQUEST['tab'])) {
            $tab = $_REQUEST['tab'];
        } else {
            $tab = 'panel_overview';
        }
        $data['tab'] = $tab;
        $last_login = (\Session::has('last_login')) ? \Session::get('last_login') : date('Y-m-d H:i:s');
        $data['last_login'] = \App\Common::TiemElapasedString($last_login);
        $user_info = \DB::table('users')
            ->where('email', \Auth::user()->email)
            ->first();
        $data['user_info'] = $user_info;
        return view('pages.admin-requester.profile',$data);
    }

    /**
     * Update User Profile
     * if user meta data exist then update else insert user meta data.
     *
     * @param  Request  $request
     * @return Response
     */
    public function ProfileUpdate(Request $request)
    {
        $user_id = \Auth::user()->id;
        $user = \DB::table('users')->where('id', $user_id)->first();
        $v = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'user_mobile' => 'Required|regex:/^[^0-9]*(88)?0/|max:11',
        ]);
        if ($v->fails()) {
            return redirect('requester/profile')->withErrors($v)->withInput();
        }
        $now = date('Y-m-d H:i:s');
        if (!empty($request->file('image_url'))) {
            $image = $request->file('image_url');
            $img_location = $image->getRealPath();
            $img_ext = $image->getClientOriginalExtension();
            $user_profile_image = \App\Admin::UserImageUpload($img_location, $request->input('email'), $img_ext);
            $user_profile_image = $user_profile_image;
        } else {
            $user_profile_image = $user->user_profile_image;
        }
        $user_info_update_data = array(
            'name' => ucwords($request->input('name')),
            'email' => $request->input('email'),
            'user_mobile' => $request->input('user_mobile'),
            'user_profile_image' => $user_profile_image,
            'updated_at' => $now,
        );
        try {
            \DB::table('users')->where('id', $user_id)->update($user_info_update_data);
            return redirect('requester/profile')->with('message',"Profile updated successfully");
        } catch (\Exception $e) {
            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            return redirect('requester/profile')->with('errormessage',"Something is wrong!");
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function ProfileImageUpdate(Request $request)
    {
        if (!empty($request->file('image_url'))) {
            $email=\Auth::user()->email;
            $image = $request->file('image_url');
            $img_location=$image->getRealPath();
            $img_ext=$image->getClientOriginalExtension();
            $user_profile_image=\App\Admin::UserImageUpload($img_location, $email, $img_ext);
            $user_profile_image=$user_profile_image;
            $user_new_img = array(
                'user_profile_image' => $user_profile_image,
            );
            try {
                \DB::table('users')
                    ->where('id', \Auth::user()->id)
                    ->update($user_new_img);
                return redirect('requester/profile')->with('message',"Profile updated successfully");
            } catch (\Exception $e) {
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                return redirect('requester/profile')->with('errormessage',$message);

            }
        }
    }

    
    /**
     * Update password for specific user
     * checked validation, if failed redirect with error message.
     *
     * @param Request $request
     * @return Response.
     */
    public function UserChangePassword(Request $request)
    {
        $now = date('Y-m-d H:i:s');

        $rules = array(
            'new_password' => 'required',
            'confirm_password' => 'required',
            'current_password' => 'required',
        );

        $v = \Validator::make(\Request::all(), $rules);

        if ($v->fails()) {
            return redirect('requester//profile?tab=change_password')
                ->withErrors($v)
                ->withInput();
        }

        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');

        if ($new_password == $confirm_password) {
            if (\Hash::check($request->input('current_password'),
                \Auth::user()->password)) {
                $update_password=array(
                    'password' => bcrypt($request->input('new_password')),
                    'plain_password' => $request->input('new_password'),
                    'updated_at' => $now
                );
                try {
                    \DB::table('users')
                        ->where('id', \Auth::user()->id)
                        ->update($update_password);
                    return redirect('requester/profile')->with('message',"Password updated successfully !");
                } catch(\Exception $e) {
                    $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                    return redirect('requester/profile')->with('errormessage',"Password update failed !");
                }
            } else {
                return redirect('requester/profile?tab=change_password')->with('errormessage',"Current Password Doesn't Match !");
            }
        } else {
            return redirect('requester/profile?tab=change_password')->with('errormessage',"Password Combination Doesn't Match !");
        }
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

            $all_content->setPath(url('/campaign/participate/countdown'));
            $pagination = $all_content->appends(['search_campaign_id' => $search_campaign_id])->render();
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

        $data['all_campaign'] =  \App\Campaign::orderby('id','desc')->where('campaign_requester_id',\Auth::user()->requester_id)->get();

        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester-campaign.countdown',$data);
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
        $all_content->setPath(url('/campaign/participate/question-'.$answer_question_id));
        $pagination = $all_content->render();
        $data['perPage'] = $all_content->perPage();
        $data['pagination'] = $pagination;
        $data['all_content'] = $all_content;

        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester-campaign.question-details',$data);
    }



    /********************************************
    ## Show the list of all payment
     *********************************************/
    public function RequesterPaymentList()
    {
        if(isset($_GET['payment_status'])){
            $all_content =  \App\CampaignPayment::where(function($query){
                if(isset($_GET['payment_status'])){
                    $query->where(function ($q){
                        $q->where('payment_status', $_GET['payment_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $payment_status = isset($_GET['payment_status'])? $_GET['payment_status']:0;

            $all_content->setPath(url('/requester/payment/list'));
            $pagination = $all_content->appends(['payment_status' => $payment_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content= \App\CampaignPayment::orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/requester/payment/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] =  \App\CampaignPayment::orderby('id','desc')->get();
        $data['requester_info'] =  \App\Requester::where('id', \Auth::user()->requester_id)->orderby('id','desc')->first();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.admin-requester.payment-history',$data);
    }






    /********************************************
    ## Show the list of all Content
     *********************************************/
    public function getAllContent()
    {
        if(isset($_GET['campaign_status'])){

            $all_content =  \App\Campaign::where(function($query){
                if(isset($_GET['campaign_status'])){
                    $query->where(function ($q){
                        $q->where('campaign_status', $_GET['campaign_status']);
                    });
                }
            })
            	->where('campaign_requester_id',\Auth::user()->requester_id)
                ->orderBy('id','DESC')
                ->paginate(20);

            $campaign_status = isset($_GET['campaign_status'])? $_GET['campaign_status']:0;

            $all_content->setPath(url('/requester/campaign/list'));
            $pagination = $all_content->appends(['campaign_status' => $campaign_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{

            $all_content= \App\Campaign::orderBy('id','DESC')->where('campaign_requester_id',\Auth::user()->requester_id)->paginate(20);
            $all_content->setPath(url('/requester/campaign/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] =  \App\Campaign::orderby('id','desc')->where('campaign_requester_id',\Auth::user()->requester_id)->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester-campaign.list',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {
        $data['select_requester'] = \App\Requester::where('id',\Auth::user()->requester_id)->first();
        $data['all_category'] = \App\Category::where('category_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester-campaign.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'campaign_name' => 'required',
            'campaign_title' => 'required',
            'campaign_category' => 'required',
            'campaign_requester_name' => 'required',
            'campaign_requester_id' => 'required',
            'campaign_requester_mobile' => 'Required|regex:/^[^0-9]*(88)?0/|max:11',
            'campaign_create_date' => 'required',
            'campaign_start_date' => 'required',
            'campaign_end_date' => 'required',
            'campaign_num_of_days' => 'required',
            'campaign_total_cost' => 'required',
            // 'campaign_cost_for_surveyer' => 'required',
            // 'campaign_zone' => 'required',
            // 'campaign_total_num_of_zone' => 'required',
            // 'campaign_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=480,height=270|max:1024',
        ]);


        if($v->passes()){
            
            $campaign_image="";
            $image_type="campaign";

            try{

                $campaign_name=$request->input('campaign_name');
                if($request->file('campaign_image')!=null){
                    #ImageUpload
                    $image_wide = $request->file('campaign_image');
                    $img_location_wide=$image_wide->getRealPath();
                    $img_ext_wide=$image_wide->getClientOriginalExtension();
                    $campaign_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$campaign_name);

                }


                $data['campaign_name']=$request->input('campaign_name');
                $slug=explode(' ', strtolower($request->input('campaign_name')));
                $campaign_name_slug=implode('-', $slug);
                $data['campaign_name_slug']=$campaign_name_slug;
                $data['campaign_title']=$request->input('campaign_title');
                $data['campaign_category']=$request->input('campaign_category');
                $data['campaign_requester_name']=$request->input('campaign_requester_name');
                $data['campaign_requester_id']=$request->input('campaign_requester_id');
                $data['campaign_requester_mobile']=$request->input('campaign_requester_mobile');
                $data['campaign_create_date']=$request->input('campaign_create_date');
                $data['campaign_start_date']=$request->input('campaign_start_date');
                $data['campaign_end_date']=$request->input('campaign_end_date');
                $data['campaign_num_of_days']=$request->input('campaign_num_of_days');
                $data['campaign_unique_code']= time().'-'.mt_rand();
                $data['campaign_total_cost']=$request->input('campaign_total_cost');
                $data['campaign_total_cost_paid']=0;
                $data['campaign_cost_for_surveyer']=$request->input('campaign_cost_for_surveyer');
                $data['campaign_prize_amount']=$request->input('campaign_prize_amount');
                $data['campaign_physical_prize']=$request->input('campaign_physical_prize');
                $data['campaign_zone']=$request->input('campaign_zone');
                $data['campaign_total_num_of_zone']=$request->input('campaign_total_num_of_zone');
                $data['campaign_cost_for_surveyer']=$request->input('campaign_cost_for_surveyer');
                $data['campaign_description']=$request->input('campaign_description');
                $data['campaign_published_status']= 0;
                $data['campaign_status']= 2;
                $data['campaign_image'] = $campaign_image;
                $data['campaign_created_by'] = \Auth::user()->id;
                $data['campaign_updated_by'] = \Auth::user()->id;


                $campaign_insert = \App\Campaign::firstOrCreate(
                    [
                        'campaign_name' => $data['campaign_name'],
                    ],
                    $data
                );

                if($campaign_insert->wasRecentlyCreated){

                    \App\System::EventLogWrite('insert,campaign_tbl',json_encode($data));
                    return redirect()->back()->with('message','Campaign Created Successfully');

                }else return redirect()->back()->with('errormessage','Campaign already created.');

            }catch (\Exception $e){
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in campaign Upload');
            }

        } else{
            return redirect()->back()->withErrors($v)->withInput();
        }
    }



    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['edit'] = \App\Campaign::where('id', $id)->where('campaign_requester_id',\Auth::user()->requester_id)->first();
        $data['select_requester'] = \App\Requester::where('id',\Auth::user()->requester_id)->first();
        $data['all_category'] = \App\Category::where('category_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester-campaign.edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'campaign_name' => 'required',
            'campaign_title' => 'required',
            'campaign_category' => 'required',
            'campaign_requester_name' => 'required',
            'campaign_requester_id' => 'required',
            'campaign_requester_mobile' => 'Required|regex:/^[^0-9]*(88)?0/|max:11',
            'campaign_start_date' => 'required',
            'campaign_end_date' => 'required',
            'campaign_num_of_days' => 'required',
            'campaign_total_cost' => 'required',
            // 'campaign_cost_for_surveyer' => 'required',
            // 'campaign_zone' => 'required',
            // 'campaign_total_num_of_zone' => 'required',
            // 'campaign_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=480,height=270|max:1024',
        ]);

        if($v->passes()){

            try{
                $campaign_image="";
                $image_type="campaign";

                $campaign_data=  \App\Campaign::where('id', $id)->first();

                $campaign_name=$request->input('campaign_name');
                if($request->file('campaign_image')!=null){
                    #PosterImageLong
                    $image_wide = $request->file('campaign_image');
                    $img_location_wide=$image_wide->getRealPath();
                    $img_ext_wide=$image_wide->getClientOriginalExtension();
                    $campaign_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$campaign_name);
                } else{
                    $campaign_image = $campaign_data->campaign_image;
                }


                $data['campaign_name']=$request->input('campaign_name');
                $slug=explode(' ', strtolower($request->input('campaign_name')));
                $campaign_name_slug=implode('-', $slug);
                $data['campaign_name_slug']=$campaign_name_slug;
                $data['campaign_title']=$request->input('campaign_title');
                $data['campaign_category']=$request->input('campaign_category');
                $data['campaign_requester_name']=$request->input('campaign_requester_name');
                $data['campaign_requester_id']=$request->input('campaign_requester_id');
                $data['campaign_requester_mobile']=$request->input('campaign_requester_mobile');
                $data['campaign_start_date']=$request->input('campaign_start_date');
                $data['campaign_end_date']=$request->input('campaign_end_date');
                $data['campaign_num_of_days']=$request->input('campaign_num_of_days');
                $data['campaign_total_cost']=$request->input('campaign_total_cost');
                $data['campaign_total_cost_paid']=0;
                $data['campaign_cost_for_surveyer']=$request->input('campaign_cost_for_surveyer');
                $data['campaign_prize_amount']=$request->input('campaign_prize_amount');
                $data['campaign_physical_prize']=$request->input('campaign_physical_prize');
                $data['campaign_zone']=$request->input('campaign_zone');
                $data['campaign_total_num_of_zone']=$request->input('campaign_total_num_of_zone');
                $data['campaign_cost_for_surveyer']=$request->input('campaign_cost_for_surveyer');
                $data['campaign_description']=$request->input('campaign_description');
                $data['campaign_image'] = $campaign_image;
                $data['campaign_updated_by'] = \Auth::user()->id;

                $update= \App\Campaign::where('id', $id)->update($data);

                \App\System::EventLogWrite('update,campaign_tbl',json_encode($data));

                return redirect()->back()->with('message','Content Updated Successfully !!');

            }catch (\Exception $e){

                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in Content Update !!');
            }
        }else return redirect()->back()->withErrors($v)->withInput();
    }

    /********************************************
    ## Delete
     *********************************************/
    public function Delete($id)
    {
        $delete =  \App\Campaign::where('id',$id)->where('campaign_requester_id',\Auth::user()->requester_id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,campaign_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,campaign_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }




    /********************************************
    ## Show the list of all Question
     *********************************************/
    public function getAllQuestion()
    {
        if(isset($_GET['question_status'])){
            $all_content =  \DB::table('question_tbl')->where(function($query){
                
                if(isset($_GET['question_status'])){
                    $query->where(function ($q){
                        $q->where('question_status', $_GET['question_status']);
                    });
                }

                if(isset($_GET['question_campaign_id']) && ($_GET['question_campaign_id'] != 0)){
                    $query->where(function ($q){
                        $q->where('question_campaign_id', $_GET['question_campaign_id']);
                    });
                }
            })
            	->where('question_created_by',\Auth::user()->id)
                ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_tbl.question_campaign_id')
                ->select('campaign_tbl.id AS campaign_id', 'campaign_tbl.*', 'question_tbl.*')
                ->orderBy('question_tbl.id','DESC')
                ->paginate(20);

            $question_status = isset($_GET['question_status'])? $_GET['question_status']:0;
            $question_name = isset($_GET['question_name'])? $_GET['question_name']:'';
            $question_campaign_id = isset($_GET['question_campaign_id'])? $_GET['question_campaign_id']:'';

            $all_content->setPath(url('/requester/question/list'));
            $pagination = $all_content->appends(['question_status' => $question_status, 'question_campaign_id' => $question_campaign_id ])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('question_tbl')->orderBy('question_tbl.id','DESC')
            ->where('question_created_by',\Auth::user()->id)
            ->join('campaign_tbl', 'campaign_tbl.id', '=', 'question_tbl.question_campaign_id')
            ->select('campaign_tbl.id AS campaign_id', 'campaign_tbl.*', 'question_tbl.*')
            ->paginate(20);
            $all_content->setPath(url('/requester/question/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_campaign'] =  \App\Campaign::orderby('id','desc')->where('campaign_requester_id',\Auth::user()->requester_id)->get();
        $data['all_data'] = \DB::table('question_tbl')
        		->where('question_created_by',\Auth::user()->id)->orderby('id','desc')
        		->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester-question.index',$data);
    }

    /********************************************
    ##  QuestionCreate View
     *********************************************/
    public function QuestionCreate()
    {
        $data['all_campaign'] = \DB::table('campaign_tbl')->where('campaign_status','!=', '1')->where('campaign_requester_id',\Auth::user()->requester_id)->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester-question.create',$data);
    }

    /********************************************
    ##  QuestionStore
     *********************************************/
    public function QuestionStore(Request $request)
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

            try{


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
                $data['question_published_status']=0;
                $data['question_status']=1;
                $data['question_created_by'] = \Auth::user()->id;
                $data['question_updated_by'] = \Auth::user()->id;
               


                $question_insert = \App\Question::firstOrCreate(
                    [
                        'question_title' => $data['question_title'],
                    ],
                    $data
                );

                if($question_insert->wasRecentlyCreated){

                    \App\System::EventLogWrite('insert,question_tbl',json_encode($data));
                    return redirect()->back()->with('message','Question Created Successfully');

                }else return redirect()->back()->with('errormessage','Blog already created.');

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
    /*public function ChangeQuestionPublishStatus($id, $status)
    {
        //check if this questions has any content published or not
        $content_exists =\DB::table('question_tbl')->where('id',$id)->where('question_created_by',\Auth::user()->id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['question_status']=1;
            } else{
                $data['question_status']=0;
            }
            $update=\DB::table('question_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                \App\System::EventLogWrite('update,question_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                \App\System::EventLogWrite('update,question_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this questions. Please upload and publish any content to publish this content.';
        }

    }*/


    /********************************************
    ##  QuestionEdit View
     *********************************************/
    public function QuestionEdit($id)
    {
        $edit= \DB::table('question_tbl')->where('id', $id)->where('question_created_by',\Auth::user()->id)->first();
        $data['edit'] = $edit;

        if(!empty($edit)){

        	$data['current_campaign']= \DB::table('campaign_tbl')->where('campaign_status', '2')->where('id',$edit->question_campaign_id)->first();
        }else{
        	$data['current_campaign']='';
        } 

        $data['all_campaign'] = \DB::table('campaign_tbl')->where('campaign_status', '!=', '1')->where('campaign_requester_id',\Auth::user()->requester_id)->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester-question.edit',$data);
    }

    /********************************************
    ##  QuestionUpdate
     *********************************************/
    public function QuestionUpdate(Request $request, $id)
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

                \App\System::EventLogWrite('update,question_tbl',json_encode($data));

                return redirect()->back()->with('message','Content Updated Successfully !!');

            }catch (\Exception $e){

                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in Content Update !!');
            }
        }else return redirect()->back()->withErrors($v)->withInput();
    }

    /********************************************
    ## QuestionDelete
     *********************************************/
    /*public function QuestionDelete($id)
    {
        $delete = \DB::table('question_tbl')->where('question_created_by',\Auth::user()->id)
            ->where('id',$id)
            ->delete();
        if($delete) {
            \App\System::EventLogWrite('delete,question_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            \App\System::EventLogWrite('delete,question_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }*/


/*--------------------------End-----------------------------------------*/



}
