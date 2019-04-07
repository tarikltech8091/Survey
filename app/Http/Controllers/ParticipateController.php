<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParticipateController extends Controller
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
        if(isset($_GET['participate_status'])){
            $all_content =  \DB::table('participate_tbl')->where(function($query){
                if(isset($_GET['participate_status'])){
                    $query->where(function ($q){
                        $q->where('participate_status', $_GET['participate_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $participate_status = isset($_GET['participate_status'])? $_GET['participate_status']:0;

            $all_content->setPath(url('/participate/list'));
            $pagination = $all_content->appends(['participate_status' => $participate_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('participate_tbl')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/participate/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('participate_tbl')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.participate.index',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {

        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.participate.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'participate_name' => 'required',
            'participate_email' => 'required',
            'participate_mobile' => 'required',
            'participate_age' => 'required',
            'participate_join_date' => 'required',
            'participate_district' => 'required',
            'participate_post_code' => 'required',
            'participate_address' => 'required',
            'participate_nid' => 'required',
            'participate_gender' => 'required',
            'participate_religion' => 'required',
            'participate_occupation' => 'required',
            // 'participate_zone' => 'required',
            // 'agreed_user' => 'required',
            // 'participate_profile_image' => 'required',
        ]);


        if($v->passes()){

            try{

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
                $data['participate_name_slug']=$participate_name_slug;
                $data['participate_email']=$request->input('participate_email');
                $data['participate_mobile']=$request->input('participate_mobile');
                $data['participate_gender']=$request->input('participate_gender');
                $data['participate_age']=$request->input('participate_age');
                $data['participate_religion']=$request->input('participate_religion');
                $data['participate_occupation']=$request->input('participate_occupation');
                $data['participate_join_date']=$request->input('participate_join_date');
                $data['participate_district']=$request->input('participate_district');
                $data['participate_post_code']=$request->input('participate_post_code');
                $data['participate_address']=$request->input('participate_address');
                $data['participate_nid']=$request->input('participate_nid');
                $data['participate_profile_image']=$participate_profile_image;
                $data['participate_status']=0;
                $data['participate_created_by']=\Auth::user()->id;
                $data['participate_updated_by']=\Auth::user()->id;
               

                // $insert=\DB::table('participate_tbl')->insert($data);

                $participate_insert = \App\Participate::firstOrCreate(
                    [
                        'participate_mobile' => $data['participate_mobile'],
                    ],
                    $data
                );

                if($participate_insert->wasRecentlyCreated){

                    \App\System::EventLogWrite('insert,participate_tbl',json_encode($data));
                    return redirect()->back()->with('message','participate Created Successfully');

                }else return redirect()->back()->with('errormessage','participate already created.');

            }catch (\Exception $e){
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in participate Upload');
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
        //check if this participate has any content published or not
        $content_exists =\DB::table('participate_tbl')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['participate_status']=1;
            } else{
                $data['participate_status']=0;
            }
            $update=\DB::table('participate_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,participate_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,participate_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this participate. Please upload and publish any content to publish this content.';
        }

    }


    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['edit'] = \DB::table('participate_tbl')->where('id', $id)->first();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.participate.edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'participate_name' => 'required',
            'participate_email' => 'required',
            'participate_mobile' => 'required',
            'participate_age' => 'required',
            'participate_join_date' => 'required',
            'participate_district' => 'required',
            'participate_post_code' => 'required',
            'participate_address' => 'required',
            'participate_nid' => 'required',
            'participate_gender' => 'required',
            'participate_religion' => 'required',
            'participate_occupation' => 'required',
            // 'participate_zone' => 'required',
            // 'agreed_user' => 'required',
            // 'participate_profile_image' => 'required',
        ]);

        if($v->passes()){

            try
            {

                $current_data= \DB::table('participate_tbl')->where('id', $id)->first();

                if(!empty($current_data)){

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
                    }else{
                        $participate_profile_image=$current_data->participate_profile_image;
                    }

                    $data['participate_name']=$request->input('participate_name');
                    $data['participate_name_slug']=$participate_name_slug;
                    $data['participate_email']=$request->input('participate_email');
                    $data['participate_mobile']=$request->input('participate_mobile');
                    $data['participate_gender']=$request->input('participate_gender');
                    $data['participate_age']=$request->input('participate_age');
                    $data['participate_religion']=$request->input('participate_religion');
                    $data['participate_occupation']=$request->input('participate_occupation');
                    $data['participate_join_date']=$request->input('participate_join_date');
                    $data['participate_district']=$request->input('participate_district');
                    $data['participate_post_code']=$request->input('participate_post_code');
                    $data['participate_address']=$request->input('participate_address');
                    $data['participate_nid']=$request->input('participate_nid');
                    $data['participate_profile_image']=$participate_profile_image;
                    $data['participate_status']=0;
                    $data['participate_created_by']=\Auth::user()->id;
                    $data['participate_updated_by']=\Auth::user()->id;


                    $update=\DB::table('participate_tbl')->where('id', $id)->update($data);

                    // \App\System::EventLogWrite('update,participate_tbl',json_encode($data));

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
        $delete = \DB::table('participate_tbl')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,participate_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,participate_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }




}
