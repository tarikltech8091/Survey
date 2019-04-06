<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            $all_content =  \DB::table('campaign')->where(function($query){
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
            $all_content=\DB::table('campaign')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/campaign/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('campaign')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.campaign.list',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {
        $data['all_service'] = \DB::table('service')->where('service_status','1')->orderby('id','desc')->get();
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
            'service_id' => 'required',
            'campaign_start_date' => 'required',
            'campaign_end_date' => 'required',
            // 'campaign_description' => 'required',
            // 'campaign_banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=480,height=270|max:1024',
        ]);


        if($v->passes()){
            $campaign_banner_image="";

            try{
                $campaign_name=$request->input('campaign_name');
                if($request->file('campaign_banner_image')!=null){
                    #PosterImageLong
                    $image_wide = $request->file('campaign_banner_image');
                    $img_location_wide=$image_wide->getRealPath();
                    $img_ext_wide=$image_wide->getClientOriginalExtension();
                    $campaign_banner_image=\App\Admin::blog_poster_image($img_location_wide,$img_ext_wide,$campaign_name);
                }


                $data['campaign_name']=$request->input('campaign_name');
                $slug=explode(' ', strtolower($request->input('campaign_name')));
                $campaign_name_slug=implode('-', $slug);
                $data['campaign_name_slug']=$campaign_name_slug;
                $data['service_id']=$request->input('service_id');
                $data['campaign_start_date']=$request->input('campaign_start_date');
                $data['campaign_end_date']=$request->input('campaign_end_date');
                $data['campaign_published_date']=$request->input('campaign_published_date');
                $data['campaign_quiz_points']=$request->input('campaign_quiz_points');
                $data['campaign_description']=$request->input('campaign_description');
                $data['campaign_status']= 0;
                $data['campaign_banner_image'] = $campaign_banner_image;

                $insert=\DB::table('campaign')->insert($data);

                /*$campaign_insert = \App\Blog::firstOrCreate(
                    [
                        'BLOG_TITLE' => $data['BLOG_TITLE'],
                    ],
                    $data
                );

                if($blog_insert->wasRecentlyCreated){*/

                    // \App\System::EventLogWrite('insert,campaign',json_encode($data));
                    return redirect()->back()->with('message','campaign Created Successfully');

                // }else return redirect()->back()->with('errormessage','Blog already created.');

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
        $content_exists =\DB::table('campaign')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['campaign_status']=1;
            } else{
                $data['campaign_status']=0;
            }
            $update=\DB::table('campaign')->where('id',$id)->update($data);

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
        $data['edit'] = \DB::table('campaign')->where('id', $id)->first();
        $data['all_service'] = \DB::table('service')->where('service_status','1')->orderby('id','desc')->get();
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
            'service_id' => 'required',
            'campaign_start_date' => 'required',
            'campaign_end_date' => 'required',
            // 'campaign_description' => 'required',
            // 'campaign_banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=480,height=270|max:1024',
        ]);

        if($v->passes()){

            try
            {

                $campaign_data= \DB::table('campaign')->where('id', $id)->first();


                $campaign_name=$request->input('campaign_name');
                if($request->file('campaign_banner_image')!=null){
                    #PosterImageLong
                    $image_wide = $request->file('campaign_banner_image');
                    $img_location_wide=$image_wide->getRealPath();
                    $img_ext_wide=$image_wide->getClientOriginalExtension();
                    $blog_image=\App\Admin::blog_poster_image($img_location_wide,$img_ext_wide,$campaign_name);
                } else{
                    $campaign_banner_image = $campaign_data->campaign_banner_image;
                }


                $data['campaign_name']=$request->input('campaign_name');
                
                $slug=explode(' ', strtolower($request->input('campaign_name')));
                $campaign_name_slug=implode('-', $slug);
                $data['campaign_name_slug']=$campaign_name_slug;
                $data['service_id']=$request->input('service_id');
                $data['campaign_start_date']=$request->input('campaign_start_date');
                $data['campaign_end_date']=$request->input('campaign_end_date');
                $data['campaign_published_date']=$request->input('campaign_published_date');
                $data['campaign_quiz_points']=$request->input('campaign_quiz_points');
                $data['campaign_description']=$request->input('campaign_description');
                $data['campaign_banner_image'] = $campaign_banner_image;
                $update=\DB::table('campaign')->where('id', $id)->update($data);

                // \App\System::EventLogWrite('update,campaign',json_encode($data));

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
        $delete = \DB::table('campaign')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,campaign|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,campaign|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }


}
