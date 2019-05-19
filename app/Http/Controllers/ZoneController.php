<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZoneController extends Controller
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
        if(isset($_GET['zone_status'])){
            $all_content =  \DB::table('zone_tbl')->where(function($query){
                if(isset($_GET['zone_status'])){
                    $query->where(function ($q){
                        $q->where('zone_status', $_GET['zone_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $zone_status = isset($_GET['zone_status'])? $_GET['zone_status']:0;

            $all_content->setPath(url('/zone/list'));
            $pagination = $all_content->appends(['zone_status' => $zone_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('zone_tbl')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/zone/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('zone_tbl')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.zone.index',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {
        $data['all_district']=\App\Common::AllDistrict();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.zone.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'zone_name' => 'required',
            'zone_zip_code' => 'required',
            'zone_district' => 'required',
            // 'zone_upzilla' => 'required',
            // 'zone_address_details' => 'required'
        ]);


        if($v->passes()){

            try{

                $zone_name=$request->input('zone_name');
                $slug=explode(' ', strtolower($request->input('zone_name')));
                $zone_name_slug=implode('-', $slug);
                $data['zone_name_slug']=$zone_name_slug;


                $data['zone_name']=$request->input('zone_name');
                $data['zone_name_slug']=$zone_name_slug;
                $data['zone_zip_code']=$request->input('zone_zip_code');
                $data['zone_district']=$request->input('zone_district');
                $data['zone_upzilla']=$request->input('zone_upzilla');
                $data['zone_address_details']=$request->input('zone_address_details');
                $data['zone_status']=0;
                $data['zone_created_by']=\Auth::user()->id;
                $data['zone_updated_by']=\Auth::user()->id;
               

                $insert=\DB::table('zone_tbl')->insert($data);


                if($insert){

                    \App\System::EventLogWrite('insert,zone_tbl',json_encode($data));
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
        $content_exists =\DB::table('zone_tbl')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['zone_status']=1;
            } else{
                $data['zone_status']=0;
            }
            $update=\DB::table('zone_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,zone_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,zone_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this zone. Please upload and publish any content to publish this content.';
        }

    }


    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['all_district']=\App\Common::AllDistrict();
        $data['edit'] = \DB::table('zone_tbl')->where('id', $id)->first();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.zone.edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'zone_name' => 'required',
            'zone_zip_code' => 'required',
            'zone_district' => 'required',
        ]);

        if($v->passes()){

            try
            {

                $current_data= \DB::table('zone_tbl')->where('id', $id)->first();

                if(!empty($current_data)){
                    
                    $zone_name=$request->input('zone_name');
                    $slug=explode(' ', strtolower($request->input('zone_name')));
                    $zone_name_slug=implode('-', $slug);
                    $data['zone_name_slug']=$zone_name_slug;


                    $data['zone_name']=$request->input('zone_name');
                    $data['zone_name_slug']=$zone_name_slug;
                    $data['zone_zip_code']=$request->input('zone_zip_code');
                    $data['zone_district']=$request->input('zone_district');
                    $data['zone_upzilla']=$request->input('zone_upzilla');
                    $data['zone_address_details']=$request->input('zone_address_details');
                    $data['zone_updated_by']=\Auth::user()->id;


                    $update=\DB::table('zone_tbl')->where('id', $id)->update($data);

                    // \App\System::EventLogWrite('update,zone_tbl',json_encode($data));

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
        $delete = \DB::table('zone_tbl')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,zone_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,zone_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }



}
