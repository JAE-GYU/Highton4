<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    /**
     * login
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $inputVal = $request->all();

        if (\Auth::attempt(['email' => $inputVal['email'], 'password' => $inputVal['password']])) {
            $user = \Auth::user();

            $data = [
                'id' => $user->id,
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
            return response()->json([
                'error' => [
                    'code' => 400,
                    'message' => [
                        '아이디나 비밀번호를 확인해주세요.'
                    ],
                ]
            ],400,[],JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputVal = $request->all();
        $inputVal['provider'] = '';
        $inputVal['provider_id'] = '';
        $inputVal['pic'] = '';
        $inputVal['password'] = bcrypt($inputVal['password']);

        $user = User::where(['email' => $inputVal['email']])->first();

        if ($user) {
            return response()->json([
                'error' => [
                    'code' => 400,
                    'message' => [
                        '이미 존재하는 아이디 입니다.'
                    ],
                ]
            ],400,[],JSON_UNESCAPED_UNICODE);
        }

        $id = User::create($inputVal)->id;

        return response()->json([
            'data' => [
                'code' => 201,
                'message' => [
                    'success',
                    $id
                ],
            ]
        ],201,[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'gender' => $user->gender,
                    'age' => $user->age,
                    'area1' => $user->area1,
                    'area2' => $user->area2,
                    'pic' => $user->pic,
                ],
            ]
        ],200,[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);        

        $user->update($request->all());

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => [
                    'success',
                    $id
                ],
            ]
        ],200,[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => [
                    'success',
                    $id
                ],
            ]
        ],200,[],JSON_UNESCAPED_UNICODE);
    }
}
