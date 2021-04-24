<?php

namespace App\Http\Controllers;

use App\Models\Skills;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Skills::where('user_id','=',auth()->user()->id)->get();
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
        $emptyData = $this->validIsEmpty($request,['name', 'rating']);
        if ($emptyData) {
            return  response()->json(['status' => 'error', 'message' => $this->errorFeildes($emptyData)], 400);
        }
        try {
            $alldata = $request->only('name', 'rating');
            // add id User to array Data
            $alldata["user_id"]= auth()->user()->id;
            if (Skills::create($alldata)) {
                return  response()->json(['status' => 'success', "message" => "Add New Skills..."], 201);
            } else {
                return  response()->json(["status" => "Faild", "message" => "Erro In Add New Skills. Please Try Again"], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $skills = Skills::findOrFail($id);
            return  response()->json($skills,200);
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $skills = Skills::findOrFail($id);
            if($skills->user_id != auth()->user()->id){
                return  response()->json(["status"=> "Faild", "message" => " Please check for Access !"],401);
            }
            $emptyData = $this->validIsEmpty($request,['name', 'rating']);
            if($emptyData){
                return  response()->json(['status'=> 'error', 'message'=>$this->errorFeildes($emptyData)],400);
            }

            if ($skills->update($request->only('name', 'rating'))) {
                return  response()->json(['status' => 'success',"message"=> "Update  Skills By Id..."],201);
            }else{
                return  response()->json(["status"=> "Faild", "message" => "Erro In Update Skills. Please Try Again"],400);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skills  $skills
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $skills = Skills::findOrFail($id);
            if ($skills->delete()) {
                return  response()->json(['status' => 'success',"message"=> "Deleted  Skills By Id ..."],200);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }
}
