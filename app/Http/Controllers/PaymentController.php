<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
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
    public function CampaignPaymentList()
    {
        if(isset($_GET['payment_status'])){
            $all_content =  \DB::table('campaign_payment_history_tbl')->where(function($query){
                if(isset($_GET['payment_status'])){
                    $query->where(function ($q){
                        $q->where('payment_status', $_GET['payment_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $payment_status = isset($_GET['payment_status'])? $_GET['payment_status']:0;

            $all_content->setPath(url('/campaign/payment/list'));
            $pagination = $all_content->appends(['payment_status' => $payment_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('campaign_payment_history_tbl')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/campaign/payment/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('campaign_payment_history_tbl')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.payment.campaign-list',$data);
    }

    /********************************************
    ##  CampaignPayment
     *********************************************/
    public function CampaignPayment()
    {
        $data['all_campaign'] = \App\Campaign::where('campaign_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.payment.campaign',$data);
    }

    /********************************************
    ##  CampaignPaymentStore
     *********************************************/
    public function CampaignPaymentStore(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'payment_campaign_id' => 'required',
            'payment_campaign_name' => 'required',
            'payment_requester_id' => 'required',
            'payment_date' => 'required',
            'payment_type' => 'required',
            'payment_amount' => 'required',
            'payment_transaction_id' => 'required',
            // 'payment_description' => 'required',
        ]);


        if($v->passes()){

            try{

                $data['payment_campaign_id']=$request->input('payment_campaign_id');
                $data['payment_campaign_name']=$request->input('payment_campaign_name');
                $data['payment_requester_id']=$request->input('payment_requester_id');
                $data['payment_date']=$request->input('payment_date');
                $data['payment_type']=$request->input('payment_type');
                $data['payment_amount']=$request->input('payment_amount');
                $data['payment_transaction_id']=$request->input('payment_transaction_id');
                $data['payment_description']=$request->input('payment_description');
                $data['payment_status']= 0;
                $data['assign_created_by'] = \Auth::user()->id;
                $data['assign_updated_by'] = \Auth::user()->id;

                // $campaign_info=\DB::table('campaign_tbl')->where('id', $data['payment_campaign_id'])->first();
                // $requester_info=\DB::table('requester_tbl')->where('id', $data['payment_requester_id'])->first();
                // $campaign_update=\DB::table('campaign_tbl')->where('id', $data['payment_campaign_id'])->update($data);
                // $requester_update=\DB::table('requester_tbl')->where('id', $data['payment_campaign_id'])->update($data);

                
                $insert=\DB::table('campaign_payment_history_tbl')->insert($data);


                // \App\System::EventLogWrite('insert,campaign_payment_history_tbl',json_encode($data));
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
    public function ChangeCampaignPaymentStatus($id, $status)
    {
        //check if this campaign payment has any content published or not
        $content_exists =\DB::table('campaign_payment_history_tbl')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['payment_status']=1;
            } else{
                $data['payment_status']=0;
            }
            $update=\DB::table('campaign_payment_history_tbl')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,payment_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,payment_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this campaign. Please upload and publish any content to publish this content.';
        }

    }

    /********************************************
    ##  CampaignPaymentEdit View
     *********************************************/
    public function CampaignPaymentEdit($id)
    {
        $data['edit'] = \App\CampaignPayment::where('id', $id)->first();
        $data['all_campaign'] = \App\Campaign::where('campaign_status','1')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.payment.campaign-edit',$data);
    }

    /********************************************
    ##  Update
     *********************************************/
    public function CampaignPaymentUpdate(Request $request, $id)
    {
        $v = \Validator::make($request->all(), [
            'payment_campaign_id' => 'required',
            'payment_campaign_name' => 'required',
            'payment_requester_id' => 'required',
            'payment_date' => 'required',
            'payment_type' => 'required',
            'payment_amount' => 'required',
            'payment_transaction_id' => 'required',
            // 'payment_description' => 'required',
        ]);

        if($v->passes()){

            try{

                $current_data= \DB::table('campaign_payment_history_tbl')->where('id', $id)->first();

                if(empty($current_data))
				return redirect()->back()->with('message','Content Not Found !!');

                $data['payment_campaign_id']=$request->input('payment_campaign_id');
                $data['payment_campaign_name']=$request->input('payment_campaign_name');
                $data['payment_requester_id']=$request->input('payment_requester_id');
                $data['payment_date']=$request->input('payment_date');
                $data['payment_type']=$request->input('payment_type');
                $data['payment_amount']=$request->input('payment_amount');
                $data['payment_transaction_id']=$request->input('payment_transaction_id');
                $data['payment_description']=$request->input('payment_description');
                $data['payment_status']= 0;
                $data['assign_updated_by'] = \Auth::user()->id;

                $update=\DB::table('campaign_payment_history_tbl')->where('id', $id)->update($data);

                // \App\System::EventLogWrite('update,campaign_payment_history_tbl',json_encode($data));

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
        $delete = \DB::table('campaign_payment_history_tbl')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,campaign_payment_history_tbl|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,campaign_payment_history_tbl|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }


}
