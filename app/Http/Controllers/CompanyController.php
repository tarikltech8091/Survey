<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
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
        if(isset($_GET['company_status'])){
            $all_content =  \DB::table('company')->where(function($query){
                if(isset($_GET['company_status'])){
                    $query->where(function ($q){
                        $q->where('company_status', $_GET['company_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $company_status = isset($_GET['company_status'])? $_GET['company_status']:0;
            $blog_type = isset($_GET['blog_type'])? $_GET['blog_type']:'all';

            $all_content->setPath(url('/company/list'));
            $pagination = $all_content->appends(['company_status' => $company_status, 'BLOG_TYPE'=> $blog_type])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('company')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/all/company/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $blog_all->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('company')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.company.list',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {
        $data['edit'] = \DB::table('company')->where('id', $id)->first();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.company.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'BLOG_TITLE' => 'required',
            'BLOG_IMAGE' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);


        if($v->passes()){
            $content_image="";

            // try{

                $data['BLOG_TITLE']=$request->input('BLOG_TITLE');

                $data['content_image'] = $content_image;

                $data_info = \DB::table('company')->first();

                if(!empty($data_info)){
                    $insert=\DB::table('company')->insert($data);
                }else{
                    $update=\DB::table('company')->where('id', $id)->update($data);
                }

                // \App\System::EventLogWrite('insert,company',json_encode($data));
                return redirect()->back()->with('message','Company Created Successfully');

            // }catch (\Exception $e){
            //     $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            //     \App\System::ErrorLogWrite($message);
            //     return redirect()->back()->with('errormessage','Something wrong happend in company Upload');
            // }
        } else{
            return redirect()->back()->withErrors($v)->withInput();
        }
    }


    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'BLOG_IMAGE' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if($v->passes()){

            try
            {

                $content_data= \DB::table('company')->where('id', $id)->first();

                $data['BLOG_TITLE']=$request->input('BLOG_TITLE');


                $update=\DB::table('company')->where('id', $id)->update($data);

                // \App\System::EventLogWrite('update,company',json_encode($data));

                return redirect()->back()->with('message','Content Updated Successfully !!');

            }catch (\Exception $e){

                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                // \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in Content Update !!');
            }
        }else return redirect()->back()->withErrors($v)->withInput();
    }


}
