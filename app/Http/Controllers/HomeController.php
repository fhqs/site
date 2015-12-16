<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;

class HomeController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */

    public function index(Request $request){         
        if(! $request->session()->get('user')){
            return redirect('signin');
        }
        else{
            $data['user'] = $request->session()->get('user');
            return View::make('home', $data);
        }
    }
    public function showProfile(Request $request, $id)
    {
        $value = $request->session()->get('key');

        //
    }
}