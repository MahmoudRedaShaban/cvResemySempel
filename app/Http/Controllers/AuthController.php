<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        # TODO Create Login Other  Defrant Login Passport
        /*  $email = $request->email;
        $password = $request->password;
        // check if field is not empty
        if(empty($email) || empty($password)){
            return response()->json(['status'=> 'error', 'message'=>'You must fill all fields.']);
        }
        // using Lip Http [Guzzle] to post request
        $client =  new Client();

        try { //Connection refused for URI
            $result = $client->post(
            // $result = $client->request('POST',
                config('service.passport.login_endpoint'),[
                "form_params" => [
                    "client_secret" => config('service.passport.PASSPORT_CLIENT_SECRET'),
                    "grant_type" => "password",
                    "client_id" => config('service.passport.PASSPORT_CLIENT_ID'),
                    "username"=> $email,
                    "password" =>$password
                    ]
                    ]);
                    return response()->json(['status'=> 'success','message'=>''.$email.''.$password]);
        } catch (BadResponseException $e) {
            return response()->json(['status'=> 'error','message'=>$e->getMessage()]);
        } */
    }



    public function register(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        // check if field is not empty
        if(empty($name) or empty($email) or empty($password)){
            return response()->json(['status'=> 'error', 'message'=>'You must Fill all the fields']);
        }
        // check if Email is valid
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return response()->json(['status'=> 'error', 'message'=>'You must enter a valid email']);
        }
        //check if password is geater than 5 character
        if(strlen($password)<6){
            return response()->json(['status'=> 'error', 'message'=>'Password should be main 6 character']);
        }
        // check if user already exist
        if(User::where('email','=',$email)->exists()){
            return response()->json(['status'=> 'error', 'message'=>'User already exists with this email']);
        }

        //create New User
        try {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = app('hash')->make($password);
            if($user->save()){
                $result = $this->login($request);
                return response()->json(['status'=> 'success', 'message'=>'User Created successfuly','login'=>$result]);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()]);
        }

    }

    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->each(function ($token)
            {
                $token->delete();
            });
            return response()->json(['status'=> 'success', 'message'=>'Logged out Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status'=> 'error', 'message'=>$e->getMessage()]);
        }
    }
}
