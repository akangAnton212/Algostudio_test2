<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Route;

class LoginController extends Controller
{
    public function login(Request $request)
    {   
        $input = $request->all();
        
        $this->validate($request, [
            'username' => 'required',
            // 'username' => 'required',
            'password' => 'required',
            // '_answer' => 'required|simple_captcha',
        ]);

        $arrayauthuser = [
            'email'         => $input['username'],
            'password'      => $input['password'],
        ];
       
        if(auth()->attempt($arrayauthuser))
        {
            return redirect()->route('utama');
        }else{
            return redirect()->route('login_again')->with(['alertprogress' => 'Email-Address And Password Are Wrong.']);
        }
    }
}
