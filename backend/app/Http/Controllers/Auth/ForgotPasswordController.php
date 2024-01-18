<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Admin;

use Validator;
use Mail;
use Log;


class ForgotPasswordController extends Controller
{

    /**
    * 会員用のパスワードのリセット処理
    * @param \Illuminate\Http\Request
    * @return JSON
    */
    public function user_password_reset(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_email' => 'required|email',
        ]);

        if ($validator->fails())
        {

            return response()->json(['input_error' => $validator->errors()], 422);

        }

        $new_password = substr(bin2hex(random_bytes(16)), 0, 16);

        if (User::where('user_email', $request->user_email)->exists())
        {

            $user = User::where('user_email', $request->user_email)->
                        orderBy('user_id', 'DESC')->
                        first();

            if ($user->status == 'A')
            {

                $user->password = bcrypt($new_password);
                $user->save();
                $user->tokens()->delete();


                $in_data = array (
                    'user_email' => $request->user_email,
                    'new_password' => $new_password,
                    'url' => env('FRONT_URL'),
                );

                Mail::send(['text' => 'password-reset-user'], $in_data, function($message) use($in_data)
                {

                    $message->from(env('MAIL_FROM_ADDRESS'));
                    $message->to($in_data['user_email'])->subject(config('subject.MAIL_RESET_SUBJECT'));

                });

                return response()->json(['success' => true], 200);

            }
            else
            {

                return response()->json(['other_error' => __('messages.this_account_is_unavailable')], 422);

            }

        }
        else
        {

            return response()->json(['other_error' => __('messages.input_email_doesnt_exist')], 422);

        }

    }

    /**
    * 管理者陽のパスワードのリセット処理
    * @param \Illuminate\Http\Request
    * @return JSON
    */
    public function admin_password_reset(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'admin_email' => 'required|email',
        ]);

        if ($validator->fails())
        {

            return response()->json(['input_error' => $validator->errors()], 422);

        }

        $new_password = substr(bin2hex(random_bytes(16)), 0, 16);

        if (Admin::where('admin_email', $request->admin_email)->exists())
        {

            $admin = Admin::where('admin_email', $request->admin_email)->
                        orderBy('admin_id', 'DESC')->
                        first();

            if ($admin->status == 'A')
            {

                $admin->password = bcrypt($new_password);
                $admin->save();

                $in_data = array (
                    'admin_email' => $request->admin_email,
                    'new_password' => $new_password,
                    'url' => env('FRONT_URL'),
                );

                Mail::send(['text' => 'password-reset-admin'], $in_data, function($message) use($in_data)
                {

                    $message->from(env('MAIL_FROM_ADDRESS'));
                    $message->to($in_data['admin_email'])->subject(config('subject.MAIL_RESET_SUBJECT'));

                });

                return response()->json(['success' => true], 200);

            }
            else
            {

                return response()->json(['other_error' => __('messages.this_account_is_unavailable')], 422);

            }

        }
        else
        {

            return response()->json(['other_error' => __('messages.input_email_doesnt_exist')], 422);

        }

    }

}
