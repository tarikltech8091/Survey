<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveyerController extends Controller
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
        if(isset($_GET['surveyer_status'])){
            $all_content =  \DB::table('surveyer_tbl')->where(function($query){
                if(isset($_GET['surveyer_status'])){
                    $query->where(function ($q){
                        $q->where('surveyer_status', $_GET['surveyer_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $surveyer_status = isset($_GET['surveyer_status'])? $_GET['surveyer_status']:0;

            $all_content->setPath(url('/surveyer/list'));
            $pagination = $all_content->appends(['surveyer_status' => $surveyer_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('surveyer_tbl')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/surveyer/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('surveyer_tbl')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.surveyer.index',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {

        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.surveyer.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'surveyer_name' => 'required',
            'surveyer_email' => 'required',
            'surveyer_mobile' => 'required',
            'surveyer_join_date' => 'required',
            'surveyer_district' => 'required',
            'surveyer_post_code' => 'required',
            'surveyer_address' => 'required',
            'surveyer_nid' => 'required',
            // 'surveyer_zone' => 'required',
            // 'surveyer_profile_image' => 'required',
        ]);


        if($v->passes()){

            try{

        	    $surveyer_profile_image='';
        	    $image_type='surveyer';

                $surveyer_name=$request->input('surveyer_name');
                $slug=explode(' ', strtolower($request->input('surveyer_name')));
                $surveyer_name_slug=implode('-', $slug);
                $data['surveyer_name_slug']=$surveyer_name_slug;

                if($request->file('surveyer_profile_image')!=null){
                    #PosterImageLong
                    $image_wide = $request->file('surveyer_profile_image');
                    $img_location_wide=$image_wide->getRealPath();
                    $img_ext_wide=$image_wide->getClientOriginalExtension();
                    $surveyer_profile_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$surveyer_name);
                }

                $data['surveyer_name']=$request->input('surveyer_name');
                $data['surveyer_name_slug']=$surveyer_name_slug;
                $data['surveyer_email']=$request->input('surveyer_email');
                $data['surveyer_mobile']=$request->input('surveyer_mobile');
                $data['surveyer_join_date']=$request->input('surveyer_join_date');
                $data['surveyer_district']=$request->input('surveyer_district');
                $data['surveyer_post_code']=$request->input('surveyer_post_code');
                $data['surveyer_address']=$request->input('surveyer_address');
                $data['surveyer_nid']=$request->input('surveyer_nid');
                $data['surveyer_zone']=$request->input('surveyer_zone');
                $data['surveyer_profile_image']=$surveyer_profile_image;
                $data['surveyer_status']=0;
                $data['surveyer_created_by']=\Auth::user()->id;
                $data['surveyer_updated_by']=\Auth::user()->id;
               

                // $insert=\DB::table('surveyer_tbl')->insert($data);

                $surveyer_insert = \App\Surveyer::firstOrCreate(
                    [
                        'surveyer_mobile' => $data['surveyer_mobile'],
                    ],
                    $data
                );

                if($surveyer_insert->wasRecentlyCreated){

                    \App\System::EventLogWrite('insert,surveyer_tbl',json_encode($data));
                    return redirect()->back()->with('message','Surveyer Created Successfully');

                }else return redirect()->back()->with('errormessage','surveyer already created.');

            }catch (\Exception $e){
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in surveyer Upload');
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
        //check if this surveyer has any content published or not
        $content_exists =\DB::table('surveyer_tbl')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['surveyer_status']=1;
            } else{
                $data['surveyer_status']=0;
            }
            $update=\DB::table('surveyer_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,surveyer_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,surveyer_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this surveyer. Please upload and publish any content to publish this content.';
        }

    }


    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['edit'] = \DB::table('surveyer_tbl')->where('id', $id)->first();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.surveyer.edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'surveyer_name' => 'required',
            'surveyer_email' => 'required',
            'surveyer_mobile' => 'required',
            'surveyer_join_date' => 'required',
            'surveyer_district' => 'required',
            'surveyer_post_code' => 'required',
            'surveyer_address' => 'required',
            'surveyer_nid' => 'required',
            // 'surveyer_zone' => 'required',
            // 'surveyer_profile_image' => 'required',
        ]);

        if($v->passes()){

            try
            {

                $current_data= \DB::table('surveyer_tbl')->where('id', $id)->first();

                if(!empty($current_data)){
	                
	        	    $surveyer_profile_image='';
	        	    $image_type='surveyer';

	                $surveyer_name=$request->input('surveyer_name');
	                $slug=explode(' ', strtolower($request->input('surveyer_name')));
	                $surveyer_name_slug=implode('-', $slug);
	                $data['surveyer_name_slug']=$surveyer_name_slug;

	                if($request->file('surveyer_profile_image')!=null){
	                    #PosterImageLong
	                    $image_wide = $request->file('surveyer_profile_image');
	                    $img_location_wide=$image_wide->getRealPath();
	                    $img_ext_wide=$image_wide->getClientOriginalExtension();
	                    $surveyer_profile_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$surveyer_name);
	                }else{
	                	$surveyer_profile_image=$current_data->surveyer_profile_image;
	                }

	                $data['surveyer_name']=$request->input('surveyer_name');
	                $data['surveyer_name_slug']=$surveyer_name_slug;
	                $data['surveyer_email']=$request->input('surveyer_email');
	                $data['surveyer_mobile']=$request->input('surveyer_mobile');
	                $data['surveyer_join_date']=$request->input('surveyer_join_date');
	                $data['surveyer_district']=$request->input('surveyer_district');
	                $data['surveyer_post_code']=$request->input('surveyer_post_code');
	                $data['surveyer_address']=$request->input('surveyer_address');
	                $data['surveyer_nid']=$request->input('surveyer_nid');
	                $data['surveyer_zone']=$request->input('surveyer_zone');
	                $data['surveyer_profile_image']=$surveyer_profile_image;
	                $data['surveyer_updated_by']=\Auth::user()->id;


	                $update=\DB::table('surveyer_tbl')->where('id', $id)->update($data);

	                // \App\System::EventLogWrite('update,surveyer_tbl',json_encode($data));

	                return redirect()->back()->with('message','Content Updated Successfully !!');
	                
	            }else return redirect()->back()->with('message','Content not found !!');

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
        $delete = \DB::table('surveyer_tbl')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,surveyer_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,surveyer_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }


}
