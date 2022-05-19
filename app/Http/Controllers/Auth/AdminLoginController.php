<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AdminLoginController extends Controller
{
    
    public function __construct(){
    	// $this->middleware('guest:admin',['except'=>['logout']]);
    }

    public function showLoginForm(){

      if (Auth::guard('admin')->check()) {
        return redirect('/backoffice/dashboard');
      }else{
        return view('auth/login');
      }
      
    }
    
    public function login(Request $request){
      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
          // if successful
        if(Auth::guard('admin')->user()->status == 'Y'){
          // usernae password status sucessful | มีอยู่ในระบบ เงื่อนไขตรง เข้าสู่ระบบสำเร็จ
          return redirect()->intended(route('backend.dashboard'));
        }else{
          // username password | มีอยู่ในระบบ แต่สถานะไม่ใช่ Y
          Auth::guard('admin')->logout();
          return redirect()->intended(route('backend.login'));
        }
      }else{
        // username paswword | ไม่มีอยู่ในระบบ
        return redirect()->intended(route('backend.login'));
      }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->intended(route('backend.login'));
    }
}
