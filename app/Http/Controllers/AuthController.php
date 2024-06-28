<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function storeAuth()
    {

        $data = [
            'client_id'=> config('salla.client_id'),
            'client_secret' => config('salla.client_secret'),
            'response_type' => 'code',
            'scope' => 'offline_access',
            'redirect_url' => config('salla.callback_url'),
            'state' => rand(111111110,999999999)
        ];

        $query = http_build_query($data);
        return redirect(config('salla.auth_url').'?'.$query);
    }

    public function callback(Request $request)
    {

        $data = [
            'client_id'=> config('salla.client_id'),
            'client_secret' => config('salla.client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'scope' => 'offline_access',
            'redirect_url' => config('salla.callback_url'),
            'state' => $request->state,
        ];

        $response = Http::asForm()->post(config('salla.token_url'),$data);

        $json_response = json_decode($response->body());

        if($response->successful())
        {
            $url = config('salla.salla_api_url') . '/store/info';

            $store_info = Http::withToken($json_response->access_token)->acceptJson()->get($url);
            if($store_info->successful())
            {
                $jsonObject = json_decode($store_info);
                dd($jsonObject);
            }
        }



    }
}
