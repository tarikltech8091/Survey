<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
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
        if(isset($_GET['category_status'])){
            $all_content =  \App\Category::where(function($query){
                if(isset($_GET['category_status'])){
                    $query->where(function ($q){
                        $q->where('category_status', $_GET['category_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $category_status = isset($_GET['category_status'])? $_GET['category_status']:0;

            $all_content->setPath(url('/category/list'));
            $pagination = $all_content->appends(['category_status' => $category_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content= \App\Category::orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/category/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \App\Category::orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.category.index',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.category.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'category_name' => 'required',

        ]);


        if($v->passes()){

            try{


                $category_name=$request->input('category_name');
                $slug=explode(' ', strtolower($request->input('category_name')));
                $category_name_slug=implode('-', $slug);
                $data['category_name_slug']=$category_name_slug;

                $data['category_name']=$request->input('category_name');

                $data['category_status']=0;
                $data['category_created_by']=\Auth::user()->id;
                $data['category_updated_by']=\Auth::user()->id;
               

                // $insert=\DB::table('category_tbl')->insert($data);

                $category_insert = \App\Category::firstOrCreate(
                    [
                        'category_name' => $data['category_name'],
                    ],
                    $data
                );

                if($category_insert->wasRecentlyCreated){

                    \App\System::EventLogWrite('insert,category_tbl',json_encode($data));
                    return redirect()->back()->with('message','category Created Successfully');

                }else return redirect()->back()->with('errormessage','category already created.');

            }catch (\Exception $e){
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in category Upload');
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
        //check if this category has any content published or not
        $content_exists =\App\Category::where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['category_status']=1;
            } else{
                $data['category_status']=0;
            }
            $update=\DB::table('category_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,category_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,category_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this category. Please upload and publish any content to publish this content.';
        }

    }


    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['edit'] = \App\Category::where('id', $id)->first();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.category.edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'category_name' => 'required',
        ]);

        if($v->passes()){

            try
            {

                $current_data= \App\Category::where('id', $id)->first();

                if(!empty($current_data)){

	                $category_name=$request->input('category_name');
	                $slug=explode(' ', strtolower($request->input('category_name')));
	                $category_name_slug=implode('-', $slug);
	                
	                $data['category_name_slug']=$category_name_slug;
	                $data['category_name']=$request->input('category_name');
	                $data['category_name_slug']=$category_name_slug;
	                $data['category_updated_by']=\Auth::user()->id;


	                $update=\App\Category::where('id', $id)->update($data);

	                // \App\System::EventLogWrite('update,category_tbl',json_encode($data));

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
        $delete = \App\Category::where('id',$id)->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,category_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,category_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }

}
