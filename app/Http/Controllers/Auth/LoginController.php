<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Validator;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

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


    // protected function guard()
    // {
    //     return Auth::guard('user');
    // }

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

    /**
     * ログイン画面の入力項目をチェック
     * @param \Illuminate\Http\Request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|email|string|max:255|bail',
            'password' => 'required|string|max:255|bail'
        ]);

    }

    /**
     * ログアウト後の遷移先を指定
     *
     * @param \Illuminate\Http\Request
     * @return void
     */
    protected function loggedOut(Request $request)
    {
        return redirect('/');
    }
}
