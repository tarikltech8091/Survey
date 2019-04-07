<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveyerAssignController extends Controller
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
        if(isset($_GET['assign_status'])){
            $all_content =  \DB::table('surveyer_assign_tbl')->where(function($query){
                if(isset($_GET['assign_status'])){
                    $query->where(function ($q){
                        $q->where('assign_status', $_GET['assign_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $assign_status = isset($_GET['assign_status'])? $_GET['assign_status']:0;

            $all_content->setPath(url('/surveyer/assign/list'));
            $pagination = $all_content->appends(['assign_status' => $assign_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
        	
            $all_content=\DB::table('surveyer_assign_tbl')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/surveyer/assign/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('surveyer_assign_tbl')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.assign.index',$data);
    }

    /********************************************
    ##  Create
     *********************************************/
    public function Create()
    {
        $data['all_campaign'] = \App\Campaign::where('campaign_status','1')->orderby('id','desc')->get();
        $data['all_surveyer'] = \App\Surveyer::where('surveyer_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.assign.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'assign_surveyer_id' => 'required',
            'assign_surveyer_name' => 'required',
            'assign_campaign_id' => 'required',
            'assign_campaign_name' => 'required',
            'assign_zone' => 'required',
            'assign_target' => 'required',
            'surveyer_prize_amount' => 'required',
            // 'assign_campaign_description' => 'required',
        ]);


        if($v->passes()){

            try{

                $data['assign_surveyer_id']=$request->input('assign_surveyer_id');
                $data['assign_surveyer_name']=$request->input('assign_surveyer_name');
                $data['assign_campaign_id']=$request->input('assign_campaign_id');
                $data['assign_campaign_name']=$request->input('assign_campaign_name');
                $data['assign_zone']=$request->input('assign_zone');
                $data['assign_target']=$request->input('assign_target');
                $data['surveyer_prize_amount']=$request->input('surveyer_prize_amount');
                $data['assign_campaign_description']=$request->input('assign_campaign_description');
                $data['assign_status']= 0;
                $data['assign_created_by'] = \Auth::user()->id;
                $data['assign_updated_by'] = \Auth::user()->id;

                $insert=\DB::table('surveyer_assign_tbl')->insert($data);
                // $update=\DB::table('campaign_tbl')->where('id', $data['payment_campaign_id'])->update($data);

                // \App\System::EventLogWrite('insert,surveyer_assign_tbl',json_encode($data));
                return redirect()->back()->with('message','Campaign Created Successfully');


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
    ## Change publish status for individual.
     *********************************************/
    public function ChangePublishStatus($id, $status)
    {
        //check if this campaign payment has any content published or not
        $content_exists =\DB::table('surveyer_assign_tbl')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['assign_status']=1;
            } else{
                $data['assign_status']=0;
            }
            $update=\DB::table('surveyer_assign_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,assign_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,assign_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this campaign. Please upload and publish any content to publish this content.';
        }

    }

    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['edit'] = \App\SurveyerAssign::where('id', $id)->first();
        $data['all_campaign'] = \App\Campaign::where('campaign_status','1')->orderby('id','desc')->get();
        $data['all_surveyer'] = \App\Surveyer::where('surveyer_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.assign.edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'assign_surveyer_id' => 'required',
            'assign_surveyer_name' => 'required',
            'assign_campaign_id' => 'required',
            'assign_campaign_name' => 'required',
            'assign_zone' => 'required',
            'assign_target' => 'required',
            'surveyer_prize_amount' => 'required',
            // 'assign_campaign_description' => 'required',
        ]);

        if($v->passes()){

            try{

                $current_data= \DB::table('surveyer_assign_tbl')->where('id', $id)->first();

                if(empty($current_data))
				return redirect()->back()->with('message','Content Not Found !!');


                $data['assign_surveyer_id']=$request->input('assign_surveyer_id');
                $data['assign_surveyer_name']=$request->input('assign_surveyer_name');
                $data['assign_campaign_id']=$request->input('assign_campaign_id');
                $data['assign_campaign_name']=$request->input('assign_campaign_name');
                $data['assign_zone']=$request->input('assign_zone');
                $data['assign_target']=$request->input('assign_target');
                $data['surveyer_prize_amount']=$request->input('surveyer_prize_amount');
                $data['assign_campaign_description']=$request->input('assign_campaign_description');
                $data['assign_updated_by'] = \Auth::user()->id;

                $update=\DB::table('surveyer_assign_tbl')->where('id', $id)->update($data);

                // \App\System::EventLogWrite('update,surveyer_assign_tbl',json_encode($data));

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
        $delete = \DB::table('surveyer_assign_tbl')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,surveyer_assign_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,surveyer_assign_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }


}
