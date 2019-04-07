<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EarnPaidController extends Controller
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
        if(isset($_GET['earn_paid_status'])){
            $all_content =  \DB::table('earn_paid_tbl')->where(function($query){
                if(isset($_GET['earn_paid_status'])){
                    $query->where(function ($q){
                        $q->where('earn_paid_status', $_GET['earn_paid_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $earn_paid_status = isset($_GET['earn_paid_status'])? $_GET['earn_paid_status']:0;

            $all_content->setPath(url('/campaign/payment/list'));
            $pagination = $all_content->appends(['earn_paid_status' => $earn_paid_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('earn_paid_tbl')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/campaign/payment/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('earn_paid_tbl')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.earn.list',$data);
    }

    /********************************************
    ##  Create
     *********************************************/
    public function Create()
    {
        $data['all_surveyer'] = \App\Surveyer::where('surveyer_status','1')->orderby('id','desc')->get();
        $data['all_participate'] = \App\Participate::where('participate_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.earn.create',$data);
    }

    /********************************************
    ##  Store
     *********************************************/
    public function Store(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'earn_paid_user_type' => 'required',
            /*'earn_paid_surveyer_id' => 'required',
            'earn_paid_surveyer_mobile' => 'required',
            'earn_paid_participate_id' => 'required',
            'earn_paid_participate_mobile' => 'required',*/
            'earn_paid_date' => 'required',
            'earn_paid_payment_type' => 'required',
            'earn_paid_amount' => 'required',
            'payment_transaction_id' => 'required',
            // 'earn_paid_description' => 'required',
        ]);


        if($v->passes()){

            try{

                $data['earn_paid_user_type']=$request->input('earn_paid_user_type');
                $data['earn_paid_surveyer_id']=$request->input('earn_paid_surveyer_id');
                $data['earn_paid_surveyer_mobile']=$request->input('earn_paid_surveyer_mobile');
                $data['earn_paid_participate_id']=$request->input('earn_paid_participate_id');
                $data['earn_paid_participate_mobile']=$request->input('earn_paid_participate_mobile');
                $data['earn_paid_date']=$request->input('earn_paid_date');
                $data['earn_paid_payment_type']=$request->input('earn_paid_payment_type');
                $data['earn_paid_amount']=$request->input('earn_paid_amount');
                $data['payment_transaction_id']=$request->input('payment_transaction_id');
                $data['earn_paid_description']=$request->input('earn_paid_description');
                $data['earn_paid_status']= 0;
                $data['earn_paid_created_by'] = \Auth::user()->id;
                $data['earn_paid_updated_by'] = \Auth::user()->id;

                $insert=\DB::table('earn_paid_tbl')->insert($data);


                // \App\System::EventLogWrite('insert,earn_paid_tbl',json_encode($data));
                return redirect()->back()->with('message','Earn Paid Created Successfully');


            }catch (\Exception $e){
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                // \App\System::ErrorLogWrite($message);
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
        $content_exists =\DB::table('earn_paid_tbl')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['earn_paid_status']=1;
            } else{
                $data['earn_paid_status']=0;
            }
            $update=\DB::table('earn_paid_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,earn_paid_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,earn_paid_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this earn payment. Please upload and publish any content to publish this content.';
        }

    }

    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['edit'] = \App\EarnPaid::where('id', $id)->first();
        $data['all_surveyer'] = \App\Surveyer::where('surveyer_status','1')->orderby('id','desc')->get();
        $data['all_participate'] = \App\Participate::where('participate_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.earn.edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function Update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'earn_paid_user_type' => 'required',
            /*'earn_paid_surveyer_id' => 'required',
            'earn_paid_surveyer_mobile' => 'required',
            'earn_paid_participate_id' => 'required',
            'earn_paid_participate_mobile' => 'required',*/
            'earn_paid_date' => 'required',
            'earn_paid_payment_type' => 'required',
            'earn_paid_amount' => 'required',
            'payment_transaction_id' => 'required',
            // 'earn_paid_description' => 'required',
        ]);

        if($v->passes()){

            try{

                $current_data= \DB::table('earn_paid_tbl')->where('id', $id)->first();

                if(empty($current_data))
                return redirect()->back()->with('message','Content Not Found !!');

                $data['earn_paid_user_type']=$request->input('earn_paid_user_type');
                $data['earn_paid_surveyer_id']=$request->input('earn_paid_surveyer_id');
                $data['earn_paid_surveyer_mobile']=$request->input('earn_paid_surveyer_mobile');
                $data['earn_paid_participate_id']=$request->input('earn_paid_participate_id');
                $data['earn_paid_participate_mobile']=$request->input('earn_paid_participate_mobile');
                $data['earn_paid_date']=$request->input('earn_paid_date');
                $data['earn_paid_payment_type']=$request->input('earn_paid_payment_type');
                $data['earn_paid_amount']=$request->input('earn_paid_amount');
                $data['payment_transaction_id']=$request->input('payment_transaction_id');
                $data['earn_paid_description']=$request->input('earn_paid_description');
                $data['earn_paid_updated_by'] = \Auth::user()->id;

                $update=\DB::table('earn_paid_tbl')->where('id', $id)->update($data);

                // \App\System::EventLogWrite('update,earn_paid_tbl',json_encode($data));

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
        $delete = \DB::table('earn_paid_tbl')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,earn_paid_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,earn_paid_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }



}
