<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Jobs::where('user_id','=',auth()->user()->id)->get();
            if ($data) {
                return  response()->json($data, 201);
            } else {
                return  response()->json([
                    "status" => "Faild",
                    "message" => "Not Found Data "
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $emptyData = $this->validIsEmpty($request,['connection','queue','payload',"exception"]);
        if($emptyData){
            return  response()->json(['status'=> 'error', 'message'=>$this->errorFeildes($emptyData)],400);
        }
        try {
            $alldata = $request->only(['connection','queue','payload',"exception"]);
            // $alldata = $request->all();
            // add id User to array Data
            $alldata["user_id"]=auth()->user()->id;
            $jobs = Jobs::create($alldata);
            if ($jobs) {
                return  response()->json(['status' => 'success',"message"=> "Add New   Jobs..."],201);
            }else {
                return  response()->json(["status"=> "Faild", "message" => "Erro In Add New Jobs. Please Try Again"],400);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $jobs = Jobs::findOrFail($id);
            return  response()->json($jobs,200);
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        try{
            $jobs = Jobs::findOrFail($id);
            if($jobs->user_id != auth()->user()->id){
                return  response()->json(["status"=> "Faild", "message" => " Please check for Access !"],401);
            }

            $emptyData = $this->validIsEmpty($request,['connection','queue','payload','exception']);
            if($emptyData){
                return  response()->json(['status'=> 'error', 'message'=>$this->errorFeildes($emptyData)],400);
            }
            if ($jobs->update($request->only('connection','queue','payload','exception'))) {
                return  response()->json(['status' => 'success',"message"=> "Update  Jobs By Id..."],201);
            }else{
                return  response()->json(["status"=> "Faild", "message" => "Erro In Update Jobs. Please Try Again"],400);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $jobs = Jobs::findOrFail($id);
            if($jobs->user_id != auth()->user()->id){
                return  response()->json(["status"=> "Faild", "message" => " Please check for Access !"],401);
            }

            if ($jobs->delete()) {
                return  response()->json(['status' => 'success',"message"=> "Deleted  Jobs By Id ..."],200);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }
}
