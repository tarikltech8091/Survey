<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
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
    public function getAllContent()
    {
        if(isset($_GET['question_status'])){
            $all_content =  \DB::table('questions')->where(function($query){
                if(isset($_GET['question_status'])){
                    $query->where(function ($q){
                        $q->where('question_status', $_GET['question_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $question_status = isset($_GET['question_status'])? $_GET['question_status']:0;
            $question_name = isset($_GET['question_name'])? $_GET['question_name']:'';

            $all_content->setPath(url('/questions/list'));
            $pagination = $all_content->appends(['question_status' => $question_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('questions')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/questions/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('questions')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question.index',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {
        $data['all_campaign'] = \DB::table('campaign')->where('campaign_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'question_title' => 'required',
            'question_option_1' => 'required',
            'question_option_2' => 'required',
            'question_option_3' => 'required',
            'question_option_4' => 'required',
            'question_option_5' => 'required',
            'question_answer' => 'required',
            'campaign_id' => 'required',
            //'campaign_name' => 'required',
            //'question_prize_amount' => 'required',
            //'question_points' => 'required',
        ]);


        if($v->passes()){

            try{


                $data['question_title']=$request->input('question_title');
                $data['question_option_1']=$request->input('question_option_1');
                $data['question_option_2']=$request->input('question_option_2');
                $data['question_option_3']=$request->input('question_option_3');
                $data['question_option_4']=$request->input('question_option_4');
                $data['question_option_5']=$request->input('question_option_5');
                $data['question_answer']=$request->input('question_answer');
                $data['campaign_id']=$request->input('campaign_id');
                $data['campaign_name']=$request->input('campaign_name');
                $data['question_prize_amount']=$request->input('question_prize_amount');
                $data['question_points']=$request->input('question_points');
                $data['question_special']=1;
                $data['question_status']=1;
               

                $insert=\DB::table('questions')->insert($data);

                /*$question_insert = \App\Blog::firstOrCreate(
                    [
                        'question_title' => $data['question_title'],
                    ],
                    $data
                );

                if($question_insert->wasRecentlyCreated){*/

                    // \App\System::EventLogWrite('insert,questions',json_encode($data));
                    return redirect()->back()->with('message','Question Created Successfully');

                // }else return redirect()->back()->with('errormessage','Blog already created.');

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
        $content_exists =\DB::table('questions')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['question_status']=1;
            } else{
                $data['question_status']=0;
            }
            $update=\DB::table('questions')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,question_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,question_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this questions. Please upload and publish any content to publish this content.';
        }

    }


    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['edit'] = \DB::table('questions')->where('id', $id)->first();
        $data['all_campaign'] = \DB::table('campaign')->where('campaign_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.question.edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'question_title' => 'required',
            'question_option_1' => 'required',
            'question_option_2' => 'required',
            'question_option_3' => 'required',
            'question_option_4' => 'required',
            'question_option_5' => 'required',
            'question_answer' => 'required',
            'campaign_id' => 'required',
            //'campaign_name' => 'required',
            //'question_prize_amount' => 'required',
            //'question_points' => 'required',
        ]);

        if($v->passes()){

            try
            {

                $question_data= \DB::table('questions')->where('id', $id)->first();

                $question_title=$request->input('question_title');

                $data['question_title']=$request->input('question_title');
                $data['question_option_1']=$request->input('question_option_1');
                $data['question_option_2']=$request->input('question_option_2');
                $data['question_option_3']=$request->input('question_option_3');
                $data['question_option_4']=$request->input('question_option_4');
                $data['question_option_5']=$request->input('question_option_5');
                $data['question_answer']=$request->input('question_answer');
                $data['campaign_id']=$request->input('campaign_id');
                $data['campaign_name']=$request->input('campaign_name');
                $data['question_prize_amount']=$request->input('question_prize_amount');
                $data['question_points']=$request->input('question_points');


                $update=\DB::table('questions')->where('id', $id)->update($data);

                // \App\System::EventLogWrite('update,questions',json_encode($data));

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
        $delete = \DB::table('questions')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,questions|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,questions|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }


}
