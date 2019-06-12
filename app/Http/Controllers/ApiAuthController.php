<?php

namespace App\Http\Controllers;

use App\User;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    //

    public function update(User $user, Request $request)
    {


        $data = $this->validate($request,[
            'email' =>'required',
            'name' => 'required',
            'password' => 'required',
            'type' => 'required',
        ]);

        $user = User::where('email' , $request-> email)->first();

        $user->update($request->all());
        $user->save();
        return $user;

    }

    public function register(Request $request)
    {

        $validatedData = $this->validate($request,[
            'email' =>'required',
            'name' => 'required',
            'password' => 'required',
            'type' => 'required',
        ]);

        $user = User::firstOrNew(['email' => $request->email]);
        $user-> name = $request-> name;
        $user-> email = $request->email;
        $user-> type = $request -> type;
        $user-> password = bcrypt($request->password);
        $user->save();

        return $user;
//        $http = new Client;
//        $response = $http->post('http://your-app.com/oauth/token',[
//            'form_params' => [
//                'grant_type' => 'password',
//                'client_id'  => '2',
//                'client_secret' => 'client_secret',
//                'username' => $request->email,
//                'password' => $request->password,
//                'scope' => ''
//            ]
//        ]);
//        return response(['data' =>json_decode((string) $response->getBody() ,true)]) ;
    }

    public function login(Request $request){

        $validatedData = $this->validate($request,[
            'email' =>'required',
            'password' => 'required'
        ]);

        $user = User::where('email' , $request-> email)->first();

        if(!$user){
            return response(['status'=>'error' , 'message'=>'user not found']);
        }

        if(Hash::check($request->password , $user->password)){
            return $user;
        }

    }


}
