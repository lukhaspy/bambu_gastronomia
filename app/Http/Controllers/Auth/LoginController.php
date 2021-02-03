<?php

namespace App\Http\Controllers\Auth;

use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller{

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user){

        $branch = Branch::all();
        $request->session()->put('dBranch', $user->default_branch);
        $request->session()->put('dataBranch', $branch->pluck('name','id'));

    }
}
