<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

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
            $all_content =  \App\CampaignPayment::where(function($query){
                if(isset($_GET['payment_status'])){
                    $query->where(function ($q){
                        $q->where('payment_status', $_GET['payment_status']);
                    });
                }
            })
                ->join('requester_tbl', 'requester_tbl.id', '=', 'campaign_payment_history_tbl.payment_requester_id')
                ->select('campaign_payment_history_tbl.id AS campaign_payment_id', 'campaign_payment_history_tbl.*' , 'requester_tbl.*')
                ->orderBy('campaign_payment_history_tbl.id','DESC')
                ->paginate(20);

            $payment_status = isset($_GET['payment_status'])? $_GET['payment_status']:0;

            $all_content->setPath(url('/campaign/payment/list'));
            $pagination = $all_content->appends(['payment_status' => $payment_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content= \App\CampaignPayment::join('requester_tbl', 'requester_tbl.id', '=', 'campaign_payment_history_tbl.payment_requester_id')
                ->select('campaign_payment_history_tbl.id AS campaign_payment_id', 'campaign_payment_history_tbl.*' , 'requester_tbl.*')
                ->orderBy('campaign_payment_history_tbl.id','DESC')
                ->paginate(20);
            $all_content->setPath(url('/campaign/payment/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] =  \App\CampaignPayment::orderby('id','desc')->get();
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
            /*'payment_campaign_name' => 'required',
            'payment_requester_id' => 'required',*/
            'payment_date' => 'required',
            'payment_type' => 'required',
            'payment_amount' => 'required',
            'payment_transaction_id' => 'required',
        ]);


        if($v->passes()){

            try{

                $success = \DB::transaction(function () use($request) {


                    $payment_campaign_id=$request->input('payment_campaign_id');

                    $campaign_info = \App\Campaign::where('id',$payment_campaign_id)->first();

                    $data['payment_campaign_id']=$request->input('payment_campaign_id');
                    $data['payment_campaign_name']=$campaign_info->campaign_name;
                    $data['payment_requester_id']=$campaign_info->campaign_requester_id;
                    $data['payment_date']=$request->input('payment_date');
                    $data['payment_type']=$request->input('payment_type');
                    $data['payment_amount']=$request->input('payment_amount');
                    $data['payment_transaction_id']=$request->input('payment_transaction_id');
                    $data['payment_description']=$request->input('payment_description');
                    $data['payment_status']= 1;
                    $data['assign_created_by'] = \Auth::user()->id;
                    $data['assign_updated_by'] = \Auth::user()->id;

                    $campaign_data['campaign_total_cost_paid']=$campaign_info->campaign_total_cost_paid + $data['payment_amount'] ;
                    $campaign_data['campaign_updated_by'] = \Auth::user()->id;


                    $campaign_update=\App\Campaign::where('id', $data['payment_campaign_id'])->update($campaign_data);

                    $requester_info=\App\Requester::where('id', $data['payment_requester_id'])->first();
                    $requester_data['requester_total_paid']=$requester_info->requester_total_paid + $data['payment_amount'] ;
                    $requester_data['requester_updated_by'] = \Auth::user()->id;

                    $requester_update=\App\Requester::where('id', $data['payment_requester_id'])->update($requester_data);

                    $insert= \App\CampaignPayment::insert($data);

                    if(!$campaign_update || !$requester_data || !$insert){
                        $error=1;
                    }

                    if(!isset($error)){
                        \App\System::EventLogWrite('insert,campaign_payment_history_tbl',json_encode($data));
                        \App\System::EventLogWrite('update,requester_tbl',json_encode($requester_data));
                        \App\System::EventLogWrite('delete,campaign_tbl',json_encode($campaign_data));
                        \DB::commit();
                        
                    }else{
                        \DB::rollback();
                        throw new Exception("Error Processing Request", 1);
                    }
                });

                return redirect()->back()->with('message','Campaign Payment Created Successfully');


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
        $content_exists = \App\CampaignPayment::where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['payment_status']=1;
            } else{
                $data['payment_status']=0;
            }
            $update= \App\CampaignPayment::where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                \App\System::EventLogWrite('update,payment_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                \App\System::EventLogWrite('update,payment_status|Status did not updated.',$id);
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
            /*'payment_campaign_name' => 'required',
            'payment_requester_id' => 'required',*/
            'payment_date' => 'required',
            'payment_type' => 'required',
            'payment_amount' => 'required',
            'payment_transaction_id' => 'required',
        ]);

        if($v->passes()){

            try{

                $current_data= \App\CampaignPayment::where('id', $id)->first();

                if(empty($current_data))
				return redirect()->back()->with('message','Content Not Found !!');

                $success = \DB::transaction(function () use($request, $current_data, $id){


                    $payment_campaign_id=$request->input('payment_campaign_id');

                    $campaign_info = \App\Campaign::where('id',$payment_campaign_id)->first();

                    $data['payment_campaign_id']=$request->input('payment_campaign_id');
                    $data['payment_campaign_name']=$campaign_info->campaign_name;
                    $data['payment_requester_id']=$campaign_info->campaign_requester_id;
                    $data['payment_date']=$request->input('payment_date');
                    $data['payment_type']=$request->input('payment_type');
                    $data['payment_amount']=$request->input('payment_amount');
                    $data['payment_transaction_id']=$request->input('payment_transaction_id');
                    $data['payment_description']=$request->input('payment_description');
                    $data['payment_status']= 0;
                    $data['assign_updated_by'] = \Auth::user()->id;


                    $campaign_info=\App\Campaign::where('id', $current_data->payment_campaign_id)->first();
                    $campaign_data['campaign_total_cost_paid']=($campaign_info->campaign_total_cost_paid) + ($data['payment_amount']) - ($current_data->payment_amount);
                    $campaign_data['campaign_updated_by'] = \Auth::user()->id;

                    $campaign_update=\App\Campaign::where('id', $current_data->payment_campaign_id)->update($campaign_data);



                    $requester_info=\App\Requester::where('id', $current_data->payment_requester_id)->first();
                    $requester_data['requester_total_paid']=($requester_info->requester_total_paid) + ($data['payment_amount']) - ($current_data->payment_amount) ;
                    $requester_data['requester_updated_by'] = \Auth::user()->id;

                    $requester_update=\App\Requester::where('id', $current_data->payment_requester_id)->update($requester_data);



                    $update= \App\CampaignPayment::where('id', $id)->update($data);

                    if($current_data->payment_amount == $data['payment_amount']){
                        if(!$update){
                            $error=1;
                        }
                    }else{
                        if(!$campaign_update || !$requester_data || !$update){
                            $error=1;
                        }
                    }

                    if(!isset($error)){
                        \App\System::EventLogWrite('update,campaign_payment_history_tbl',json_encode($data));
                        \App\System::EventLogWrite('update,requester_tbl',json_encode($requester_data));
                        \App\System::EventLogWrite('delete,campaign_tbl',json_encode($campaign_data));
                        \DB::commit();
                        
                    }else{
                        \DB::rollback();
                        throw new Exception("Error Processing Request", 1);
                    }
                });

                return redirect()->back()->with('message','Campaign Payment Updated Successfully');


            }catch (\Exception $e){

                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in Content Update !!');
            }
        }else return redirect()->back()->withErrors($v)->withInput();
    }

    /********************************************
    ## CampaignPaymentDelete
     *********************************************/
    public function CampaignPaymentDelete($id)
    {

        try{

            $current_data= \App\CampaignPayment::where('id', $id)->first();

            if(empty($current_data)){
                echo 'Content not found.';
            }


            $success = \DB::transaction(function () use($current_data, $id){


                $campaign_info=\App\Campaign::where('id', $current_data->payment_campaign_id)->first();
                $campaign_data['campaign_total_cost_paid']=$campaign_info->campaign_total_cost_paid - $current_data->payment_amount;
                $campaign_data['campaign_updated_by'] = \Auth::user()->id;


                $campaign_update=\App\Campaign::where('id', $current_data->payment_campaign_id)->update($campaign_data);

                $requester_info=\App\Requester::where('id', $current_data->payment_requester_id)->first();
                $requester_data['requester_total_paid']=$requester_info->requester_total_paid - $current_data->payment_amount ;
                $requester_data['requester_updated_by'] = \Auth::user()->id;

                $requester_update=\App\Requester::where('id', $current_data->payment_requester_id)->update($requester_data);

                $delete =  \App\CampaignPayment::where('id',$id)->delete();


                if(!$campaign_update || !$requester_data || !$delete){
                    $error=1;
                }

                if(!isset($error)){
                    \App\System::EventLogWrite('delete,campaign_payment_history_tbl',json_encode($id));
                    \App\System::EventLogWrite('update,requester_tbl',json_encode($requester_data));
                    \App\System::EventLogWrite('delete,campaign_tbl',json_encode($campaign_data));
                    \DB::commit();
                    
                }else{
                    \DB::rollback();
                    throw new Exception("Error Processing Request", 1);
                }
            });

            echo 'Content deleted successfully.';

        }catch (\Exception $e){

            $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
            \App\System::ErrorLogWrite($message);
            echo 'Content did not delete successfully.';
        }


    }


}
