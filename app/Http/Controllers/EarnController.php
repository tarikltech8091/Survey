<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EarnController extends Controller
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
        if(isset($_GET['players_earn_status'])){
            $all_content =  \DB::table('players_earn')->where(function($query){
                if(isset($_GET['players_earn_status'])){
                    $query->where(function ($q){
                        $q->where('players_earn_status', $_GET['players_earn_status']);
                    });
                }
            })
                ->orderBy('id','DESC')
                ->paginate(20);

            $players_earn_status = isset($_GET['players_earn_status'])? $_GET['players_earn_status']:0;

            $all_content->setPath(url('/earn/list'));
            $pagination = $all_content->appends(['players_earn_status' => $players_earn_status])->render();
            $data['pagination'] = $pagination;
            $data['perPage'] = $all_content->perPage();
            $data['all_content'] = $all_content;

        } else{
            $all_content=\DB::table('players_earn')->orderBy('id','DESC')->paginate(20);
            $all_content->setPath(url('/earn/list'));
            $pagination = $all_content->render();
            $data['perPage'] = $all_content->perPage();
            $data['pagination'] = $pagination;
            $data['all_content'] = $all_content;

        }

        $data['all_data'] = \DB::table('players_earn')->orderby('id','desc')->get();
        $data['page_title'] = $this->page_title;
        $data['page_desc'] = $this->page_desc;
        return view('pages.earn.list',$data);
    }

    /********************************************
    ##  Create View
     *********************************************/
    public function Create()
    {
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
            // 'earn_player_id' => 'required',
            // 'earn_player_campaign_id' => 'required',
            // 'earn_player_campaign_name' => 'required',
            // 'earn_player_question_id' => 'required',
            // 'earn_player_mobile_num' => 'required',
            // 'earn_date' => 'required',
            // 'earn_amount' => 'required',
            // 'use_life' => 'required',
            // 'earn_status' => 'required',
        ]);


        if($v->passes()){

            // try{


                /*$data['earn_player_id']=$request->input('earn_player_id');
                $data['earn_player_campaign_id']=$request->input('earn_player_campaign_id');
                $data['earn_player_campaign_name']=$request->input('earn_player_campaign_name');
                $data['earn_player_question_id']=$request->input('earn_player_question_id');
                $data['earn_player_mobile_num']=$request->input('earn_player_mobile_num');
                $data['earn_date']=$request->input('earn_date');
                $data['earn_amount']=$request->input('earn_amount');
                $data['use_life']=$request->input('use_life');
                $data['earn_status']=0;*/



                $data['earn_player_id']=1;
                $data['earn_player_campaign_id']=1;
                $data['earn_player_campaign_name']='sddsa';
                $data['earn_player_question_id']=1;
                $data['earn_player_mobile_num']=1;
                $data['earn_date']=$request->input('earn_date');
                $data['earn_amount']=1;
                $data['use_life']='yes';
                $data['earn_status']=0;

                $insert=\DB::table('players_earn')->insert($data);

                /*$earn_insert = \App\Earn::firstOrCreate(
                    [
                        'earn_player_id' => $data['earn_player_id'],
                    ],
                    $data
                );

                if($blog_insert->wasRecentlyCreated){*/

                    // \App\System::EventLogWrite('insert,players_earn',json_encode($data));
                    return redirect()->back()->with('message','Earn Created Successfully');

                // }else return redirect()->back()->with('errormessage','Earn already created.');

            }catch (\Exception $e){
                $message = "Message : ".$e->getMessage().", File : ".$e->getFile().", Line : ".$e->getLine();
                \App\System::ErrorLogWrite($message);
                return redirect()->back()->with('errormessage','Something wrong happend in players_earn Upload');
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
        //check if this players_earn has any content published or not
        $content_exists =\DB::table('players_earn')->where('id',$id)->first();
        if($content_exists)
        {
            $now = date('Y-m-d H:i:s');
            if($status=='1'){
                $data['earn_status']=1;
            } else{
                $data['earn_status']=0;
            }
            $update=\DB::table('players_earn')->where('id',$id)->update($data);

            if($update) {
                echo 'Status updated successfully.';
                // \App\System::EventLogWrite('update,earn_status|Status updated successfully.',$id);
            } else {
                echo 'Status did not update.';
                // \App\System::EventLogWrite('update,earn_status|Status did not updated.',$id);
            }
        } else{
            echo 'There is no published content for this players_earn. Please upload and publish any content to publish this content.';
        }

    }


    /********************************************
    ##  Edit View
     *********************************************/
    public function Edit($id)
    {
        $data['edit'] = \DB::table('players_earn')->where('id', $id)->first();
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
            // 'earn_player_id' => 'required',
            // 'earn_player_campaign_id' => 'required',
            // 'earn_player_campaign_name' => 'required',
            // 'earn_player_question_id' => 'required',
            // 'earn_player_mobile_num' => 'required',
            // 'earn_date' => 'required',
            // 'earn_amount' => 'required',
            // 'use_life' => 'required',
            // 'earn_status' => 'required',
        ]);

        if($v->passes()){

            try
            {

                $content_data= \DB::table('players_earn')->where('id', $id)->first();


                /*$data['earn_player_id']=$request->input('earn_player_id');
                $data['earn_player_campaign_id']=$request->input('earn_player_campaign_id');
                $data['earn_player_campaign_name']=$request->input('earn_player_campaign_name');
                $data['earn_player_question_id']=$request->input('earn_player_question_id');
                $data['earn_player_mobile_num']=$request->input('earn_player_mobile_num');
                $data['earn_date']=$request->input('earn_date');
                $data['earn_amount']=$request->input('earn_amount');
                $data['use_life']=$request->input('use_life');
                $data['earn_status']=0;*/



                $data['earn_player_id']=1;
                $data['earn_player_campaign_id']=1;
                $data['earn_player_campaign_name']='sddsa';
                $data['earn_player_question_id']=1;
                $data['earn_player_mobile_num']=100;
                $data['earn_date']=$request->input('earn_date');
                $data['earn_amount']=100;
                $data['use_life']='no';
                $data['earn_status']=0;


                $update=\DB::table('players_earn')->where('id', $id)->update($data);

                // \App\System::EventLogWrite('update,players_earn',json_encode($data));

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
        $delete = \DB::table('players_earn')
            ->where('id',$id)
            ->delete();
        if($delete) {
            // \App\System::EventLogWrite('delete,players_earn|Content deleted successfully.',$id);
            echo 'Content deleted successfully.';
        } else {
            // \App\System::EventLogWrite('delete,players_earn|Content did not delete.',$id);
            echo 'Content did not delete successfully.';
        }
    }


}
