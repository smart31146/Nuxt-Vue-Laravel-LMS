<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use Log;

class UsersController extends Controller
{

    /**
     * ユーザーのデータ一覧取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return User
     */
    public function getAllUserData(Request $request)
    {

        $query = User::query();

        if ($request->has('user_name'))
        {

            $query->where('user_name', 'like', '%'.$request->user_name.'%');

        }

        if ($request->has('sei'))
        {

            $query->where('sei', 'like', '%'.$request->sei.'%');

        }

        if ($request->has('mei'))
        {

            $query->where('mei', 'like', '%'.$request->mei.'%');

        }

        if ($request->has('sei_kana'))
        {

            $query->where('sei_kana', 'like', '%'.$request->sei_kana.'%');

        }

        if ($request->has('mei_kana'))
        {

            $query->where('mei_kana', 'like', '%'.$request->mei_kana.'%');

        }

        if ($request->has('sex'))
        {

            $query->where('sex', $request->sex);

        }

        if ($request->has('user_rank'))
        {

            $query->where('user_rank', $request->user_rank);

        }

        if ($request->has('user_type'))
        {

            $query->where('user_type', $request->user_type);

        }

        if ($request->has('status'))
        {

            $query->where('status', $request->status);

        }

        $users = $query->orderBy('user_id', 'ASC')->
                            paginate(20);

        return $users;

    }

    /**
     * ユーザーの新規登録
     *
     * @param  UserRequest  $request
     * @return JSON
     */
    public function store(UserRequest $request)
    {

        $user = new User;
        $this->save($request, $user);

        return response()->json(
        [
            'success' => true
        ]);

    }

    /**
     * ユーザーの更新登録
     *
     * @param  UserRequest $request
     * @return JSON
     */
    public function update(UserRequest $request)
    {

        $user = User::find($request->user_id);

        $this->save($request, $user);

        $token = '';
        if ($request->has('token'))
        {

            $token = $user->createToken('mobile', ['role:user'])->plainTextToken;

        }

        return response()->json(
        [
            'success' => true,
            'token' => $token,
        ]);

    }

    /**
     * ユーザーの保存
     * @param  UserRequest $request
     * @param  User
     */
    private function save(UserRequest $request, User $user)
    {

        $user->user_email = $request->user_email;

        if ($request->has('password'))
        {

            $user->password = Hash::make($request->password);
            $user->tokens()->delete();

        }

        $user->user_name = $request->user_name;
        $user->sei = $request->sei;
        $user->mei = $request->mei;
        $user->sei_kana = $request->sei_kana;
        $user->mei_kana = $request->mei_kana;
        $user->sex = $request->sex;
        $user->tel = $request->tel;
        $user->zip = $request->zip;
        $user->prefecture = $request->prefecture;
        $user->address_01 = $request->address_01;
        $user->address_02 = $request->address_02;
        if ($request->has('user_rank'))
        {

            $user->user_rank = $request->user_rank;

        }

        if ($request->has('user_type'))
        {

            $user->user_type = $request->user_type;

        }

        $user->save();

    }

    /**
     * ユーザーの削除
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function destroy(Request $request)
    {

        $user = User::find($request->user_id);
        $user->status = 'D';
        $user->deleted_at = date('Y-m-d H:i:s');
        $user->save();

    }

    /**
     * ユーザーの復帰
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function recover(Request $request)
    {

        $user = User::find($request->user_id);
        $user->status = 'A';
        $user->deleted_at = null;
        $user->save();

    }

    /**
     * ユーザーのデータ取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return User
     */
    public function show(Request $request)
    {

        return User::find($request->user_id);

    }

    /**
     * 住所の取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function getAddress(Request $request)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.zipaddress.net/?zipcode='.$request->zip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, true);

    }

}
