<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\DataTrueResource;
use App\Http\Resources\DataFalseResource;
use App\Http\Resources\LoginResource;
use App\Traits\BuyerLoginToken;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use BuyerLoginToken;

    public function register(RegisterRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return new DataTrueResource(trans('messages.auth.registration_success'));
    }

    public function login(LoginRequest $request)
    {

        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if (!Auth::attempt($credentials))
            return new DataFalseResource(trans('messages.auth.wrong_credentials'));

        $user = $request->user();
        //generate access token
        $token = $this->getGrantAccessRefreshToken($request->get('email'), $request->get('password'));
        if ($token['success']) {
            $user->authorization = $token['access_token'];
            $user->refresh_token = $token['refresh_token'];
        } else {
            return new DataFalseResource($token['msg']);
        }
        return new LoginResource($user);
    }
}
