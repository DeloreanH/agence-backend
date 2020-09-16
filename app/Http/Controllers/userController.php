<?php

namespace App\Http\Controllers;
use App\Models\caoUser;

class userController extends Controller
{
    public $caoUser;

    public function __construct()
    {
        $this->caoUser = new caoUser();
    }


    /**
     * returns all users with consultant permission
     * @return array
     */
    public function consultans()
    {
        $users = $this->caoUser->consultans();
        return response()->json(['users' => $users],200);
    }
}


