<?php

namespace App\Traits;

use Laravel\Passport\Client;

trait BuyerLoginToken
{
    /**
     * Get access token and  refresh token when new login
     * @param $email
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function getGrantAccessRefreshToken($email, $password)
    {
        $oClient = Client::where('password_client', 1)->first();

        $data = [
            'grant_type' => 'password',
            'client_id' => $oClient->id,
            'client_secret' => $oClient->secret,
            'username' => $email,
            'password' => $password,
            'scope' => null,
        ];
        $request = app('request')->create('/oauth/token', 'POST', $data);
        $response = app('router')->prepareResponse($request, app()->handle($request));
        $token_response = (array)$response->getContent();
        $token_data = json_decode($token_response[0]);
        $statusCode = (array)$response->getStatusCode();
        $statusCode = json_decode($statusCode[0]);
        if ($statusCode == config('constants.validation_codes.success')) {
            return [
                'success' => true,
                'msg' => '',
                'access_token' => $token_data->access_token,
                'refresh_token' => $token_data->refresh_token,
            ];
        } else {
            return [
                'success' => false,
                'msg' => $token_data->error_description,
            ];
        }
    }
}

