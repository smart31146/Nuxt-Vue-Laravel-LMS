<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

use App\Models\User;
use App\Models\Admin;

use Auth;
use Validator;
use Log;

class LoginController extends Controller
{

    /**
     * 会員認証処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function user_login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails())
        {

            return response()->json(['input_error' => $validator->errors()], 422);

        }

        $user = User::where('user_email', $request->user_email)->
                    orderBy('user_id', 'DESC')->
                    first();

        if ($user != null)
        {

            if (!Hash::check($request->password, $user->password))
            {

                return response()->json(['other_error' => __('messages.password_is_invalid')], 422);

            }
            else
            {

                if ($user->status == 'D')
                {

                    return response()->json(['other_error' => __('messages.this_account_is_unavailable')], 422);

                }
                else
                {

                    return response()->json([
                        'user' => $user,
                        'token' => $user->createToken('mobile', ['role:user'])->plainTextToken,
                    ], 200);

                }

            }

        }
        else
        {

            return response()->json(['other_error' => __('messages.input_email_doesnt_exist')], 422);

        }

    }

    /**
     * 管理者認証処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function admin_login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'admin_email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails())
        {

            return response()->json(['input_error' => $validator->errors()], 422);

        }

        $admin = Admin::where('admin_email', $request->admin_email)->
                        orderBy('admin_id', 'DESC')->
                        first();

        if ($admin != null)
        {

            if (!Hash::check($request->password, $admin->password))
            {

                return response()->json(['other_error' => __('messages.password_is_invalid')], 422);

            }
            else
            {

                if ($admin->status == 'D')
                {

                    return response()->json(['other_error' => __('messages.this_account_is_unavailable')], 422);

                }
                else
                {

                    $start_date = new \DateTime($admin->start_date);
                    $today = new \DateTime(date('Y-m-d'));
                    if ($start_date > $today)
                    {

                        return response()->json(['other_error' => __('messages.this_account_is_unavailable')], 422);

                    }

                    if ($admin->end_date != null)
                    {

                        $end_date = new \DateTime($admin->end_date);
                        if ($end_date < $today)
                        {

                            return response()->json(['other_error' => __('messages.this_account_is_unavailable')], 422);

                        }

                    }

                    return response()->json([
                        'admin' => $admin,
                        'token' => $admin->createToken('mobile', ['role:admin'])->plainTextToken,
                    ], 200);

                }

            }

        }
        else
        {

            return response()->json(['other_error' => __('messages.input_email_doesnt_exist')], 422);

        }

    }

    /**
     * 会員ログアウト処理
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user_logout(Request $request)
    {

        $user = User::where('user_email', $request->user_email)->
                    orderBy('user_id', 'DESC')->
                    first();
        $user->tokens()->delete();
        return response()->json(['message' => 'logout'], 200);

    }

    /**
     * 管理者ログアウト処理
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function admin_logout(Request $request)
    {

        $admin = Admin::where('admin_email', $request->admin_email)->
                    orderBy('admin_id', 'DESC')->
                    first();
        $admin->tokens()->delete();
        return response()->json(['message' => 'logout'], 200);

    }

    /**
     * ユーザー情報をトークンで取得する処理
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_user_by_token(Request $request)
    {

        $status = 422;
        $user = null;

        $token = PersonalAccessToken::findToken($request->token);
        if ($token != null)
        {

            $user = $token->tokenable;
            if ($user)
            {
                $status = 200;
            }

        }

        return response()->json(['user' => $user], $status);

    }

    /**
     * 管理者情報をトークンで取得する処理
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_admin_by_token(Request $request)
    {

        $status = 422;
        $admin = null;

        $token = PersonalAccessToken::findToken($request->token);
        if ($token != null)
        {

            $admin = $token->tokenable;
            if ($admin)
            {
                $status = 200;
            }

        }

        return response()->json(['admin' => $admin], $status);

    }

    /**
     * ユーザーの退会処理
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdrawal(Request $request)
    {

        $user = User::where('user_email', $request->user_email)->
                    orderBy('user_id', 'DESC')->
                    first();
        $user->status = 'D';
        $user->deleted_at = date('Y-m-d H:i:s');
        $user->save();

        $user->tokens()->delete();
        return response()->json(['message' => 'logout'], 200);

    }

    /**
     * ユーザーの認証
     *
     * @param  \Illuminate\Http\Request  $request
     * @return User
     */
    public function checkUserAuth(Request $request)
    {

        $ret = false;

        $token = PersonalAccessToken::findToken($request->token);
        if ($token != null)
        {

            $ret = true;

        }

        return response()->json(['result' => $ret]);

    }

}
