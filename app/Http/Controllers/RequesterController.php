<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequesterController extends Controller
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
        if(isset($_GET['requester_status'])){
            $all_content =  \DB::table('requester_tbl')->where(function($query){
                if(isset($_GET['requester_status'])){
                    $query->where(function ($q){
                        $q->where('requester_status', $_GET['requester_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $requester_status = isset($_GET['requester_status'])? $_GET['requester_status']:0;

            $all_content->setPath(url('/requester/list'));
            $pagination = $all_content->appends(['requester_status' => $requester_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('requester_tbl')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/requester/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('requester_tbl')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester.index',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {
        $data['all_district']=\App\Common::AllDistrict();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'requester_name' => 'required',
            'requester_email' => 'required',
            'requester_mobile' => 'required',
            'requester_join_date' => 'required',
            'requester_district' => 'required',
            'requester_post_code' => 'required',
            'requester_address' => 'required',
            'requester_nid' => 'required',
            // 'requester_profile_image' => 'required',
        ]);


        if($v->passes()){

            try{

                $requester_profile_image='';
                $image_type='requester';

                $requester_name=$request->input('requester_name');
                $slug=explode(' ', strtolower($request->input('requester_name')));
                $requester_name_slug=implode('-', $slug);
                $data['requester_name_slug']=$requester_name_slug;

                if($request->file('requester_profile_image')!=null){
                    #ImageUpload
                    $image_wide = $request->file('requester_profile_image');
                    $img_location_wide=$image_wide->getRealPath();
                    $img_ext_wide=$image_wide->getClientOriginalExtension();
                    $requester_profile_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$requester_name);
                }

                $data['requester_name']=$request->input('requester_name');
                $data['requester_name_slug']=$requester_name_slug;
                $data['requester_email']=$request->input('requester_email');
                $data['requester_mobile']=$request->input('requester_mobile');
                $data['requester_join_date']=$request->input('requester_join_date');
                $data['requester_district']=$request->input('requester_district');
                $data['requester_post_code']=$request->input('requester_post_code');
                $data['requester_address']=$request->input('requester_address');
                $data['requester_nid']=$request->input('requester_nid');
                $data['requester_profile_image']=$requester_profile_image;
                $data['requester_status']=0;
                $data['requester_created_by']=\Auth::user()->id;
                $data['requester_updated_by']=\Auth::user()->id;
               

                // $insert=\DB::table('requester_tbl')->insert($data);

                $requester_insert = \App\Requester::firstOrCreate(
                    [
                        'requester_mobile' => $data['requester_mobile'],
                    ],
                    $data
                );

                if($requester_insert->wasRecentlyCreated){

                    \App\System::EventLogWrite('insert,requester_tbl',json_encode($data));
                    return redirect()->back()->with('message','requester Created Successfully');

                }else return redirect()->back()->with('errormessage','requester already created.');

            }catch (\Exception $e){
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in requester Upload');
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
        //check if this requester has any content published or not
        $content_exists =\DB::table('requester_tbl')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['requester_status']=1;
            } else{
                $data['requester_status']=0;
            }
            $update=\DB::table('requester_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,requester_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,requester_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this requester. Please upload and publish any content to publish this content.';
        }

    }


    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['all_district']=\App\Common::AllDistrict();
        $data['edit'] = \DB::table('requester_tbl')->where('id', $id)->first();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.requester.edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'requester_name' => 'required',
            'requester_email' => 'required',
            'requester_mobile' => 'required',
            'requester_join_date' => 'required',
            'requester_district' => 'required',
            'requester_post_code' => 'required',
            'requester_address' => 'required',
            'requester_nid' => 'required',
            // 'requester_profile_image' => 'required',
        ]);

        if($v->passes()){

            try
            {

                $current_data= \DB::table('requester_tbl')->where('id', $id)->first();

                if(!empty($current_data)){
                    
                    $requester_profile_image='';
                    $image_type='requester';

                    $requester_name=$request->input('requester_name');
                    $slug=explode(' ', strtolower($request->input('requester_name')));
                    $requester_name_slug=implode('-', $slug);
                    $data['requester_name_slug']=$requester_name_slug;

                    if($request->file('requester_profile_image')!=null){
                        #PosterImageLong
                        $image_wide = $request->file('requester_profile_image');
                        $img_location_wide=$image_wide->getRealPath();
                        $img_ext_wide=$image_wide->getClientOriginalExtension();
                        $requester_profile_image=\App\Admin::CommonImageUpload($img_location_wide,$img_ext_wide,$image_type,$requester_name);
                    }else{
                        $requester_profile_image=$current_data->requester_profile_image;
                    }

                    $data['requester_name']=$request->input('requester_name');
                    $data['requester_name_slug']=$requester_name_slug;
                    $data['requester_email']=$request->input('requester_email');
                    $data['requester_mobile']=$request->input('requester_mobile');
                    $data['requester_join_date']=$request->input('requester_join_date');
                    $data['requester_district']=$request->input('requester_district');
                    $data['requester_post_code']=$request->input('requester_post_code');
                    $data['requester_address']=$request->input('requester_address');
                    $data['requester_nid']=$request->input('requester_nid');
                    $data['requester_profile_image']=$requester_profile_image;
                    $data['requester_updated_by']=\Auth::user()->id;


                    $update=\DB::table('requester_tbl')->where('id', $id)->update($data);

                    // \App\System::EventLogWrite('update,requester_tbl',json_encode($data));

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
        $delete = \DB::table('requester_tbl')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,requester_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,requester_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }



}
