<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use Validator;
use Log;

class RegisterController extends Controller
{

    /**
     * 新規会員登録処理
     *
     * @param  Request $request
     * @return JSON
     */
    public function registration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_name' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails())
        {

            return response()->json(['input_error' => $validator->errors()], 422);

        }

        $user = new User;
        $user->user_email = $request->user_email;
        $user->password = Hash::make($request->password);
        $user->user_name = $request->user_name;
        $user->save();

        return response()->json([
            'success' => true
        ], 200);

    }
}
