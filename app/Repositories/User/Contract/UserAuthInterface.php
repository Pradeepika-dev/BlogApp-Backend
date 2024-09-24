<?php

namespace App\Repositories\User\Contract;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Request;

interface UserAuthInterface
{
    public function register(UserRequest $request);

    public function login(UserRequest $request);

    public function logout($request);
}