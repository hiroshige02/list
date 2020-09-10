<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    use AuthenticatesUsers;

   /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * ログイン画面
     *
     * @return void
     */

    function showLoginForm(){
        $viewData = [];
        $viewData['title'] = 'ログイン';
        
        return view('auth.login', $viewData);
    }

    function authenticate(Request $request){
        $credentials = $request->only('mail_address', 'password');

        if (Auth::attempt($credentials)) {
            // 認証に成功した
            return redirect()->intended('/maintenance');
        }        
    }

    function logout(){
        Auth::logout();     
    }
}