<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    function create(Request $req){
    
        $user = User::create([
            "name"=> "Kemo",
             "email"=> "example2@google.com",
             "password" => bcrypt("123456")
        ]);
        return $user;

    }
}
