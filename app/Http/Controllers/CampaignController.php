<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requester;

class CampaignController extends Controller
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
        if(isset($_GET['campaign_status'])){
            $all_content =  \DB::table('campaign_tbl')->where(function($query){
                if(isset($_GET['campaign_status'])){
                    $query->where(function ($q){
                        $q->where('campaign_status', $_GET['campaign_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $campaign_status = isset($_GET['campaign_status'])? $_GET['campaign_status']:0;
            $blog_type = isset($_GET['blog_type'])? $_GET['blog_type']:'all';

            $all_content->setPath(url('/campaign/list'));
            $pagination = $all_content->appends(['campaign_status' => $campaign_status, 'BLOG_TYPE'=> $blog_type])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('campaign_tbl')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/campaign/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('campaign_tbl')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.campaign.list',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {
        $data['all_requester'] = \App\Requester::where('requester_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.campaign.create',$data);
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
            'campaign_requester_mobile' => 'required',
            'campaign_create_date' => 'required',
            'campaign_start_date' => 'required',
            'campaign_end_date' => 'required',
            'campaign_num_of_days' => 'required',
            'campaign_total_cost' => 'required',
            'campaign_cost_for_surveyer' => 'required',
            'campaign_zone' => 'required',
            'campaign_total_num_of_zone' => 'required',
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
                $data['campaign_total_cost_paid']=$request->input('campaign_total_cost_paid');
                $data['campaign_cost_for_surveyer']=$request->input('campaign_cost_for_surveyer');
                $data['campaign_prize_amount']=$request->input('campaign_prize_amount');
                $data['campaign_physical_prize']=$request->input('campaign_physical_prize');
                $data['campaign_zone']=$request->input('campaign_zone');
                $data['campaign_total_num_of_zone']=$request->input('campaign_total_num_of_zone');
                $data['campaign_cost_for_surveyer']=$request->input('campaign_cost_for_surveyer');
                $data['campaign_description']=$request->input('campaign_description');
                $data['campaign_published_status']= 0;
                $data['campaign_status']= 0;
                $data['campaign_image'] = $campaign_image;
                $data['campaign_created_by'] = \Auth::user()->id;
                $data['campaign_updated_by'] = \Auth::user()->id;

                // $insert=\DB::table('campaign_tbl')->insert($data);

                $campaign_insert = \App\Campaign::firstOrCreate(
                    [
                        'campaign_name' => $data['campaign_name'],
                    ],
                    $data
                );

                if($campaign_insert->wasRecentlyCreated){

                    // \App\System::EventLogWrite('insert,campaign_tbl',json_encode($data));
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
    ## Change publish status for individual.
     *********************************************/
    public function ChangePublishStatus($id, $status)
    {
        //check if this campaign has any content published or not
        $content_exists =\DB::table('campaign_tbl')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['campaign_status']=1;
            } else{
                $data['campaign_status']=0;
            }
            $update=\DB::table('campaign_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,campaign_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,campaign_status|Status did not updated.',$id);
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
        $data['edit'] = \App\Campaign::where('id', $id)->first();
        $data['all_requester'] = \App\Requester::where('requester_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.campaign.edit',$data);
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
            'campaign_requester_mobile' => 'required',
            'campaign_start_date' => 'required',
            'campaign_end_date' => 'required',
            'campaign_num_of_days' => 'required',
            'campaign_total_cost' => 'required',
            'campaign_cost_for_surveyer' => 'required',
            'campaign_zone' => 'required',
            'campaign_total_num_of_zone' => 'required',
            // 'campaign_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=480,height=270|max:1024',
        ]);

        if($v->passes()){

            try{
                $campaign_image="";
                $image_type="campaign";

                $campaign_data= \DB::table('campaign_tbl')->where('id', $id)->first();

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
                $data['campaign_total_cost_paid']=$request->input('campaign_total_cost_paid');
                $data['campaign_cost_for_surveyer']=$request->input('campaign_cost_for_surveyer');
                $data['campaign_prize_amount']=$request->input('campaign_prize_amount');
                $data['campaign_physical_prize']=$request->input('campaign_physical_prize');
                $data['campaign_zone']=$request->input('campaign_zone');
                $data['campaign_total_num_of_zone']=$request->input('campaign_total_num_of_zone');
                $data['campaign_cost_for_surveyer']=$request->input('campaign_cost_for_surveyer');
                $data['campaign_description']=$request->input('campaign_description');
                $data['campaign_image'] = $campaign_image;
                $data['campaign_updated_by'] = \Auth::user()->id;

                $update=\DB::table('campaign_tbl')->where('id', $id)->update($data);

                // \App\System::EventLogWrite('update,campaign_tbl',json_encode($data));

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
        $delete = \DB::table('campaign_tbl')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,campaign_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,campaign_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }


}
