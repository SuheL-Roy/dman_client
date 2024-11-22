<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class LoginBlockController extends Controller
{
    public static function logout(){

        
        Auth::logout();
       
        
        return ;



      
    }

    public function redirect(){


        return redirect()->route('login')->with(['status'=>"You can not login now! Please contact system admin"]);

    }


}
