<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Repositories\User\Contract\UserAuthInterface;
use Illuminate\Support\Facades\Request as FacadesRequest;

class UserAuthController extends Controller
{
    protected $user;

    public function __construct(UserAuthInterface $user){
        $this->user = $user;
    }

    public function register(UserRequest $request)
    {
        return $this->user->register($request);
    }

    public function login(UserRequest $request)
    {
        return $this->user->login($request);        
    }

    public function logout(Request $request)
    {
        return $this->user->logout($request); 
    }
}
