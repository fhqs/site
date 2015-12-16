<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;

class WallController extends Controller
{
    /**
     * Show the wall
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */

    public function home(Request $request){         
        // Check if user is logged in
        if(! $request->session()->get('user')){
            return redirect('signin');
        }
        else {
            $data['user'] = $request->session()->get('user');
            return View::make('wall', $data);
        }
    }
    public function showProfile(Request $request, $id)
    {
        $value = $request->session()->get('key');

        //
    }
}