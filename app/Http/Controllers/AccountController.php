<?php
namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use Hash;
use Socialize;

class AccountController extends Controller
{   
    //handle post signin
    public function login(Request $request){             
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect('signin')->withErrors($validator);
        }

        //Check user existed?
        if ($validator->passes()) {
            $user = User::find($request->input('email'));

            if (Hash::check($request->input('password'), $user['password'])) {

                $request->session()->put('user', array(
                                                    'email' => $user['email'], 
                                                    'password' => $user['password'], 
                                                    'firstname'=> $user['firstname'], 
                                                    'lastname'=> $user['lastname']                                       
                                                )
                                        );

                return redirect('/');
            }else{
                return redirect('signin')->withInput()->with('loginerror', trans('user.loginerror'));
            }
        }

        return view('signin');
    }


    //handle post signup
    public function register(Request $request){     
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'gender' => 'required|max:6|in:male,female',
            'email' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return redirect('signup')->withErrors($validator);
        }

        //Check user existed?
        if ($validator->passes()) {
            $user = User::find($request->input('email'));
            if(!$user){
                //save user into database and session
                $user = new User;
                $user->email = $request->input('email');
                $user->password = Hash::make($request->input('password'));
                $user->firstname = $request->input('firstname');
                $user->lastname = $request->input('lastname');
                $user->gender = $request->input('gender');

                if($user->save()){
                    $request->session()->put('user', array(
                                                        'email' => $request->input('email'), 
                                                        'password' => Hash::make($request->input('password')), 
                                                        'firstname'=> $request->input('firstname'), 
                                                        'lastname'=> $request->input('lastname'), 
                                                        'gender'=> $request->input('gender')                                        
                                                    )
                                            );

                    return redirect('/');
                }else{
                    return redirect('signup')->withInput()->with('signuperror', trans('user.createusererror'));
                }
            }else{
                return redirect('signup')->withInput()->with('signuperror', trans('user.existed'));
            }
        }

        return view('signup');
    }

    public function logout(Request $request){
        $request->session()->forget('user');

        $request->session()->flush();

        return redirect('signin');
    }

    public function facebook(){
        return Socialize::with('facebook')->redirect();
    }

    public function callback_facebook(Request $request)
    {
        $error = $request->input('error');        
        if($error){
            return redirect('signup')->with('socialerror', trans('user.facebookerror'));
        }

        $fbuser = Socialize::with('facebook')->user();

        if(!empty($fbuser)){
            if(!empty($fbuser->user)){
                if(isset($fbuser->user['email'])){ //find if email is existed
                    $check_user = User::find($fbuser->user['email']);
                    
                    if($check_user){ //email existed -> update
                        $check_user['facebook'] = $fbuser;
                        User::upsert($check_user);
                    }else{ //email not existed -> insert                        
                        $user = new User;
                        $user->email = $fbuser->user['email'];
                        $user->firstname = $fbuser->user['first_name'];
                        $user->lastname = $fbuser->user['last_name'];
                        $user->gender = $fbuser->user['gender'];
                        $user->facebook = $fbuser;
                        $user->save();
                    }

                    //update session
                    $request->session()->put('user', array(
                                                        'email' => $fbuser->user['email'],  
                                                        'firstname'=> $fbuser->user['first_name'], 
                                                        'lastname'=> $fbuser->user['last_name'],
                                                        'gender' => $fbuser->user['gender']
                                                    )
                                            );

                    return redirect('/');
                }else{
                    return redirect('signup')->with('socialerror', trans('user.social_nullemail'));
                }
            }else{
                return redirect('signup')->with('socialerror', trans('user.facebookerror'));
            }
        }else{
            return redirect('signup')->with('socialerror', trans('user.facebookerror'));
        }
    }
}