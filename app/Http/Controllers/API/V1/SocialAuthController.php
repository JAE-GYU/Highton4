<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class SocialAuthController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();  
    }

    public function facebookCallback()
    {
        $providerUser = Socialite::driver('facebook')->user();

        $user = User::where(['provider' => 'facebook', 'provider_id' => $providerUser->getId()])->first();

        if ($user) {
            $data = [
                'provider' => $user->provider,
                'provider_id' => $user->provider_id,
                'name' => $user->name,
                'email' => $user->email,                
                'gender' => $user->gender,
                'age' => $user->age,
                'area1' => $user->area1,
                'area2' => $user->area2,
                'pic' => $user->avatar,
            ];

            return response()->json([
                'data' => [
                    'code' => 200,
                    'message' => [
                        $data
                    ],
                ]
            ],200,[],JSON_UNESCAPED_UNICODE);
        }else {
            $data = [
                'provider' => 'facebook',
                'provider_id' => $providerUser->getId(),
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'password' => '',
                'gender' => '',
                'age' => '',
                'area1' => '',
                'area2' => '',
                'pic' => $providerUser->avatar,
            ];

            $id = User::create($data)->id;

            $data['id'] = $id;

            return response()->json([
                'data' => [
                    'code' => 201,
                    'message' => [
                        'success',
                        $data
                    ],
                ]
            ],201,[],JSON_UNESCAPED_UNICODE);
        }

    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();  
    }

    public function googleCallback()
    {
        $providerUser = Socialite::driver('google')->user();        

        $user = User::where(['provider' => 'google', 'provider_id' => $providerUser->getId()])->first();

        if ($user) {
            $data = [
                'provider' => $user->provider,
                'provider_id' => $user->provider_id,
                'name' => $user->name,
                'email' => $user->email,                
                'gender' => $user->gender,
                'age' => $user->age,
                'area1' => $user->area1,
                'area2' => $user->area2,
                'pic' => $user->avatar,
            ];

            return response()->json([
                'data' => [
                    'code' => 200,
                    'message' => [
                        $data
                    ],
                ]
            ],200,[],JSON_UNESCAPED_UNICODE);
        }else {
            $data = [
                'provider' => 'google',
                'provider_id' => $providerUser->getId(),
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'password' => '',
                'gender' => '',
                'age' => '',
                'area1' => '',
                'area2' => '',
                'pic' => $providerUser->avatar,
            ];

            $id = User::create($data)->id;

            $data['id'] = $id;

            return response()->json([
                'data' => [
                    'code' => 201,
                    'message' => [
                        'success',
                        $data
                    ],
                ]
            ],201,[],JSON_UNESCAPED_UNICODE);
        }
    }    
}
