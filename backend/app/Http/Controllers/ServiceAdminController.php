<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;

use Log;

class ServiceAdminController extends Controller
{

    /**
     * 管理者アカウントのデータ一覧取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Admin
     */
    public function getAllAdminData(Request $request)
    {

        $query = Admin::query();

        if ($request->has('admin_name'))
        {

            $query->where('admin_name', 'like', '%'.$request->admin_name.'%');

        }

        if ($request->has('admin_type'))
        {

            $query->where('admin_type', $request->admin_type);

        }

        if ($request->has('status'))
        {

            $query->where('status', $request->status);

        }

        $admins = $query->orderBy('admin_id', 'ASC')->
                            paginate(20);

        return $admins;

    }

    /**
     * 管理者アカウントの新規登録
     *
     * @param  AdminRequest  $request
     * @return JSON
     */
    public function store(AdminRequest $request)
    {

        $admin = new Admin;
        $admin->admin_type = 0;
        $this->save($request, $admin);

        return response()->json(
        [
            'success' => true
        ]);

    }

    /**
     * 管理者アカウントの更新登録
     *
     * @param  AdminRequest $request
     * @return JSON
     */
    public function update(AdminRequest $request)
    {

        $admin = Admin::find($request->admin_id);

        $this->save($request, $admin);

        return response()->json(
        [
            'success' => true
        ]);

    }

    /**
     * 管理者アカウントの保存
     * @param  AdminRequest $request
     * @param  Admin
     */
    private function save(AdminRequest $request, Admin $admin)
    {

        $admin->admin_email = $request->admin_email;

        if ($request->has(('password')))
        {

            $admin->password = Hash::make($request->password);

        }

        $admin->admin_name = $request->admin_name;
        $admin->start_date = $request->start_date;
        $admin->end_date = $request->end_date;

        $admin->save();

    }

    /**
     * 管理者アカウントの削除
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function destroy(Request $request)
    {

        $admin = Admin::find($request->admin_id);
        $admin->status = 'D';
        $admin->deleted_at = date('Y-m-d H:i:s');
        $admin->save();

    }

    /**
     * 管理者アカウントの復帰
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function recover(Request $request)
    {

        $admin = Admin::find($request->admin_id);
        $admin->status = 'A';
        $admin->deleted_at = null;
        $admin->save();

    }

    /**
     * 管理者アカウントのデータ取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Admin
     */
    public function show(Request $request)
    {

        return Admin::find($request->admin_id);

    }

}
