<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use Illuminate\Http\Request;

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
            $data = auth()->user()->details;
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
            $userDetails = new UserDetails();
            $userDetails->user_id = auth()->user()->id;
            $userDetails->fullname = $request->fullname;
            $userDetails->email = $request->email;
            $userDetails->phone = $request->phone;
            $userDetails->address = $request->address;
            $userDetails->summary = $request->summary;
            if($userDetails->save()){
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
    public function show(UserDetails $userDetails)
    {
        try {

            if($userDetails->user_id != auth()->user()->id){
                return  response()->json(["status"=> "Faild", "message" => " Please check for Access !"],401);
            }

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
    public function update(Request $request, UserDetails $userDetails)
    {
        if($userDetails->user_id != auth()->user()->id){
            return  response()->json(["status"=> "Faild", "message" => " Please check for Access !"],401);
        }
        // Check For Request Data [Empty]
        $emptyData = $this->validIsEmpty($request, ['fullname', 'email', 'phone', 'address', 'summary']);
        if ($emptyData) {
        return  response()->json(['status'=> 'error', 'message'=>$this->errorFeildes($emptyData)],400);
        }
        try {
            $userDetails->fullname = $request->fullname;
            $userDetails->email = $request->email;
            $userDetails->phone = $request->phone;
            $userDetails->address = $request->address;
            $userDetails->summary = $request->summary;
            if($userDetails->save()){
                return  response()->json(['status' => 'success',"message"=> "Update  UserDetails By ID..."],201);
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
    public function destroy(UserDetails $userDetails)
    {
        try {
            if($userDetails->user_id == auth()->user()->id){
                if($userDetails->delete()){
                    return  response()->json(['status' => 'success',"message"=> "Delete  UserDetails By ID..."],201);
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
