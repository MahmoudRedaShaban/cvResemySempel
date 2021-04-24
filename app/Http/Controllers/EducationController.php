<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Education::where('user_id','=',auth()->user()->id)->get();
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
        $emptyData = $this->validIsEmpty($request,
        ['school_name', 'school_location', 'degree', "field_of_study",
        "graduation_start_date", "graduation_end_date"]);
        if ($emptyData) {
            return  response()->json(['status' => 'error', 'message' => $this->errorFeildes($emptyData)], 400);
        }
        try {
            $alldata = $request->only(['school_name', 'school_location', 'degree', "field_of_study",
            "graduation_start_date", "graduation_end_date"]);
            // add id User to array Data
            $alldata["user_id"] = auth()->user()->id;
            if (Education::create($alldata)) {
                return  response()->json(['status' => 'success', "message" => "Add New Education..."], 201);
            } else {
                return  response()->json(["status" => "Faild", "message" => "Erro In Add New Education. Please Try Again"], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $education = Education::findOrFail($id);
            return  response()->json($education,200);
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $education = Education::findOrFail($id);
            $emptyData = $this->validIsEmpty($request,['school_name', 'school_location', 'degree', "field_of_study",
            "graduation_start_date", "graduation_end_date"]);
            if($emptyData){
                return  response()->json(['status'=> 'error', 'message'=>$this->errorFeildes($emptyData)],400);
            }

            if ($education->update($request->only('school_name', 'school_location', 'degree', "field_of_study",
            "graduation_start_date", "graduation_end_date"))) {
                return  response()->json(['status' => 'success',"message"=> "Update  Education By Id..."],201);
            }else{
                return  response()->json(["status"=> "Faild", "message" => "Erro In Update Education. Please Try Again"],400);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $education = Education::findOrFail($id);
            if ($education->delete()) {
                return  response()->json(['status' => 'success',"message"=> "Deleted  Education By Id ..."],200);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }
}
