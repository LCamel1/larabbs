<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Http\Requests\Api\AuthorizationRequest;
use App\Models\User;
use Illuminate\Support\Arr;

class AuthorizationsController extends Controller
{
    /**
     * 第三方登录
     */
    public function socialStore($type, Request $request)
    {

        $driver = \Socialite::driver($type);

        try {
            if ($code = $request->code) {
                // $oauthUser = $driver->userFormCode($code);
                $res = $driver->getAccessTokenResponse($code);
                $access_token = isset($res['access_token']) ? $res['access_token'] : '';
                $openid = isset($res['openid']) ? $res['openid'] : '';
            } else {
                $access_token= $request->access_token;
                $openid = $request->openid;
            }

            //微信需要添加 openid
            if ($type == 'weixin') {
                $driver->setOpenId($openid);
            }

            $oauthUser = $driver->userFromToken($access_token);

        } catch (\Exception $e) {
            throw new AuthenticationException('参数错误，未获取用户信息');
        }

        if (!$oauthUser->getId()) {
            throw new AuthenticationException('参数错误，未获取用户信息');
        }
        switch ($type) {
            case 'weixin':
                $unionid = $oauthUser->getRaw()['unionid'] ?? null;

                if ($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if (!$user) {
                    $user = User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }

                break;
        }
		$token = auth('api')->login($user);
        return $this->respondWithToken($token)->setStatusCode(201);
    }

    /**
     * 登录
     */
    public function store(Request $request)
    {
        $username = $request->username;

        // filter_var()过滤函数，判断是否是email （登录可以是email或phone来登录）
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $username;
        } else {
             $credentials['phone'] = $username;
        }

        $credentials['password'] = $request->password;

        if (!$token = \Auth::guard('api')->attempt($credentials)) {
            throw new AuthenticationException("用户名或密码错误");
        }

        return $this->respondWithToken($token)->setStatusCode(201);

    }

    /**
     * 刷新token
     */
    public function update()
    {
        $token = auth('api')->refresh();
        return $this->respondWithToken($token);
    }

     /**
      * 删除token 退出
      */
      public function destroy()
      {
        auth('api')->logout();
        return response(null, 204);
      }






    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

}
