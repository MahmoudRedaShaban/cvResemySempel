<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = UserDetails::where('user_id','=',auth()->user()->id)->get();
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
        // Check For Request Data [Empty]
        $emptyData = $this->validIsEmpty($request, ['fullname', 'email', 'phone', 'address', 'summary']);
        if ($emptyData) {
            return  response()->json(['status'=> 'error', 'message'=>$this->errorFeildes($emptyData)],400);
        }
        try {
            $alldata = $request->only('fullname', 'email', 'phone', 'address', 'summary');
            $alldata['user_id']=auth()->user()->id;
            $userDetails = UserDetails::create($alldata);
            if($userDetails){
                return  response()->json(['status' => 'success',"message"=> "Add New UserDetails..."],201);
            }else {
                return  response()->json(["status"=> "Faild", "message" => "Erro In Add New UserDetails. Please Try Again"]);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $userDetails = UserDetails::findOrFail($id);
            return  response()->json($userDetails,200);
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()],400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        try {
            $userDetails = UserDetails::findOrFail($id);
            if($userDetails->user_id != auth()->user()->id ){
                return  response()->json(["status"=> "Faild", "message" => " Please check for Access !"],401);
            }
            // Check For Request Data [Empty]
            $emptyData = $this->validIsEmpty($request, ['fullname', 'email', 'phone', 'address', 'summary']);
            if ($emptyData) {
                return  response()->json(['status'=> 'error', 'message'=>$this->errorFeildes($emptyData)],400);
            }
            if($userDetails->update($request->only('fullname', 'email', 'phone', 'address', 'summary'))){
                return  response()->json(['status' => 'success',"message"=> "Update  UserDetails By ID..."],200);
            }else {
                return  response()->json(["status"=> "Faild", "message" => "Erro In Update UserDetails. Please Try Again"],400);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $userDetails = UserDetails::findOrFail($id);
            if($userDetails->user_id == auth()->user()->id){
                if($userDetails->delete()){
                    return  response()->json(['status' => 'success',"message"=> "Delete  UserDetails By ID..."],200);
                }else {
                    return  response()->json(["status"=> "Faild", "message" => "Erro In Delete UserDetails. Please Try Again"],400);
                }
            }else {
                return  response()->json(["status"=> "Faild", "message" => "Erro In Delete UserDetails. Please check for Access !"],401);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()],400);
        }
    }



}
