<?php

namespace App\Http\Controllers;

use App\Models\Experiences;
use Illuminate\Http\Request;

class ExperiencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Experiences::where('user_id','=',auth()->user()->id)->get();
            if ($data) {
                return  response()->json($data, 200);
            } else {
                return  response()->json(["status" => "Faild", "message" => "Not Found Data .."], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
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
        $emptyData = $this->validIsEmpty($request,['job_title', 'employer', 'city',  "state","start_date","end_date"]);
        if ($emptyData) {
            return  response()->json(['status' => 'error', 'message' => $this->errorFeildes($emptyData)], 400);
        }
        try {
            $alldata = $request->only('job_title', 'employer', 'city',  "state","start_date","end_date");
            // add id User to array Data
            $alldata["user_id"]= auth()->user()->id;
            if (Experiences::create($alldata)) {
                return  response()->json(['status' => 'success', "message" => "Add New Experiences..."], 201);
            } else {
                return  response()->json(["status" => "Faild", "message" => "Erro In Add New Experiences. Please Try Again"], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Experiences  $experiences
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $experiences = Experiences::findOrFail($id);
            return  response()->json($experiences,200);
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Experiences  $experiences
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            $experiences = Experiences::findOrFail($id);

            $emptyData = $this->validIsEmpty($request,['job_title', 'employer', 'city',  "state","start_date","end_date"]);
            if($emptyData){
                return  response()->json(['status'=> 'error', 'message'=>$this->errorFeildes($emptyData)],400);
            }


            if ($experiences->update($request->only('job_title', 'employer', 'city',  "state","start_date","end_date"))) {
                return  response()->json(['status' => 'success',"message"=> "Update  Experiences By Id..."],201);
            }else{
                return  response()->json(["status"=> "Faild", "message" => "Erro In Update Experiences. Please Try Again"],400);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Experiences  $experiences
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $experiences = Experiences::findOrFail($id);
            if ($experiences->delete()) {
                return  response()->json(['status' => 'success',"message"=> "Deleted  Experiences By Id ..."],200);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }
}
