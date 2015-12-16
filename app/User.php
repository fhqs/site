<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Eloquent;
use Hash;

class User extends Eloquent {
    protected $connection = 'mongodb';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'email', 'password', 'facebook'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function find($email){ 
        return \DB::collection('users')->where('email', $email)->first();
    }

    public static function upsert($data){
        return \DB::collection('users')->where('email', $data['email'])->update($data, array('upsert' => true));
    }
}
