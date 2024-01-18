<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CurriculumRequest;

use App\Models\Category;
use App\Models\Curriculum;
use App\Models\TakingCurriculum;
use App\Models\Certificate;
use App\Models\User;

use Log;

class CurriculumsController extends Controller
{

    /**
     * カリキュラムのデータ一覧取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Curriculum
     */
    public function getAllCurriculumData(Request $request)
    {

        $query = Curriculum::query();
        if ($request->has('authority_ranks'))
        {

            $category_ids = Category::where('status', 'A')->
                            pluck('category_id')->
                            toArray();

            if (count($category_ids) > 0)
            {

                $query->whereIn('category_id', $category_ids);

            }
            else
            {

                $query->where('category_id', 0);

            }

        }

        if ($request->has('curriculum_name_admin'))
        {

            $query->where('curriculum_name_admin', 'like', '%'.$request->curriculum_name_admin.'%');

        }

        if ($request->has('curriculum_name'))
        {

            $query->where('curriculum_name', 'like', '%'.$request->curriculum_name.'%');

        }

        if ($request->has('category_name'))
        {

            $category_query = Category::query();
            if ($request->has('authority_ranks'))
            {

                $category_query->where('status', 'A');

            }

            $category_ids =  $category_query->where('category_name', 'like', '%'.$request->category_name.'%')->
                                    pluck('category_id')->
                                    toArray();

            if (count($category_ids) > 0)
            {

                $query->whereIn('category_id', $category_ids);

            }
            else
            {

                $query->where('category_id', 0);

            }

        }

        if ($request->has('release_type'))
        {

            $query->where('release_type', $request->release_type);

        }

        if ($request->has('is_required'))
        {

            $query->where('is_required', $request->is_required);

        }

        if ($request->has('curriculum_type'))
        {

            $query->where('curriculum_type', $request->curriculum_type);

        }

        if ($request->has('status'))
        {

            $query->where('status', $request->status);

        }

        if ($request->has('authority_ranks'))
        {

            if ($request->authority_ranks == '0')
            {

                $query->where('authority_ranks', $request->authority_ranks);

            }
            else
            {

                $query->where(function($query) use($request)
                {
                    $query->where('authority_ranks', 0)->
                            orWhere(function($query) use($request)
                            {
                                $query->where('authority_ranks', $request->authority_ranks)->
                                orWhere('authority_ranks', 'like', $request->authority_ranks.',%')->
                                orWhere('authority_ranks', 'like', '%,'.$request->authority_ranks.',%')->
                                orWhere('authority_ranks', 'like', '%,'.$request->authority_ranks);
                            });
                });

            }

            $query->where(function($query)
            {
                $query->where('release_type', 1)->
                orWhere(function($query)
                {
                    $query->where('release_type', 2)->
                    whereDate('released_at', '<=', date('Y-m-d H:i:s'))->
                    whereDate('closed_at', '>=', date('Y-m-d H:i:s'));

                });
            });

        }

        if ($request->has('created_at'))
        {

            $created_timestamp = new \DateTime($request->created_at);

            $query->where(function($query) use($created_timestamp)
            {

                $query->where(function($query)
                {
                    $query->where('released_date_count', 0)->
                            whereNull('released_time')->
                            where('closed_date_count', 0)->
                            whereNull('closed_time');
                })->orWhere(function($query) use($created_timestamp)
                {

                    $query->whereRaw("DATE_ADD(? , INTERVAL concat(released_date_count, ' ', released_time) DAY_SECOND) <= now()" , [$created_timestamp->format('Y-m-d 00:00:00')])->
                    whereRaw("DATE_ADD(? , INTERVAL concat(closed_date_count, ' ', closed_time) DAY_SECOND) >= now()" , [$created_timestamp->format('Y-m-d 00:00:00')]);

                });

            });

        }

        if ($request->has('order_item'))
        {

            $query->orderBy($request->order_item, $request->order_by);

        }
        else
        {

            $query->orderBy('curriculum_id', 'ASC');

        }

        $curriculums = $query->paginate(20);

        return $curriculums;

    }

    /**
     * 有効な全てのカリキュラムの取得
     *
     * @return Curriculum
     */
    public function getActiveCurriculums()
    {

        $ret = array();

        $curriculums = Curriculum::where('status', 'A')->
                            orderBy('curriculum_id', 'ASC')->
                            get();

        if ($curriculums != null)
        {

            foreach ($curriculums as $curriculum)
            {

                $ret[] = array(
                    'key' => $curriculum->curriculum_id,
                    'value' => $curriculum->curriculum_name,
                );

            }

        }

        return response()->json([
            'curriculums' => $ret
        ]);

    }

    /**
     * カリキュラムの新規登録
     *
     * @param  CurriculumRequest  $request
     * @return JSON
     */
    public function store(CurriculumRequest $request)
    {

        $curriculum = new Curriculum;
        $curriculum->curriculum_slug = md5(sha1(uniqid(mt_rand(), true)));
        $this->save($request, $curriculum);

        return response()->json(
        [
            'success' => true
        ]);

    }

    /**
     * カリキュラムの更新登録
     *
     * @param  CurriculumRequest $request
     * @return JSON
     */
    public function update(CurriculumRequest $request)
    {

        $curriculum = Curriculum::where('curriculum_slug', $request->curriculum_slug)->first();

        $this->delete($request, $curriculum, 'curriculum_image_change', 'curriculum_image', config('const.CURRICULUM_IMAGE_DIR_PATH'));

        if ($request->curriculum_type != $curriculum->curriculum_type)
        {

            if ($curriculum->curriculum_type == '1')
            {

                $curriculum->movie_url = null;
                $curriculum->save();

            }

            if ($curriculum->curriculum_type == '2')
            {

                $this->delete($request, $curriculum, 'audio_file_change', 'audio_file', config('const.AUDIO_DIR_PATH'), true);

            }

        }
        else
        {

            $this->delete($request, $curriculum, 'audio_file_change', 'audio_file', config('const.AUDIO_DIR_PATH'));

        }

        for ($i = 1; $i <= 5; $i++)
        {

            $this->delete($request, $curriculum, 'pdf_file_change'.$i, 'pdf_file'.$i, config('const.PDF_DIR_PATH'));

        }

        if ($request->release_type != $curriculum->release_type)
        {

            $curriculum->released_at = null;
            $curriculum->closed_at = null;
            $curriculum->save();

        }

        $this->save($request, $curriculum);

        return response()->json(
        [
            'success' => true
        ]);

    }

    /**
     * 削除処理
     * @param  CurriculumRequest  $request
     * @param  Curriculum $curriculum
     * @param  String $change_name
     * @param  String $field_name
     * @param  String $path
     * @param  bool $is_force
     */
    private function delete(CurriculumRequest $request, Curriculum $curriculum, String $change_name, String $field_name, String $path, bool $is_force = false)
    {

        if ($is_force || $request->has($change_name))
        {

            $file = public_path($path.$curriculum->$field_name);
            unlink($file);
            $curriculum->$field_name = null;
            $curriculum->save();

        }

    }

    /**
     * カリキュラムの保存
     * @param  CurriculumRequest  $request
     * @param  Curriculum $curriculum
     * @param  String $field_name
     * @param  String $path
     * @return  $curriculum
     */
    private function saveItem(CurriculumRequest $request, Curriculum $curriculum, String $field_name, String $path)
    {

        $item_name = '';
        $value_array = array();

        for ($i = 1; $i <= 5; $i++)
        {

            $item_name = $field_name.$i;
            if ($request->has($item_name))
            {

                $new_file = md5(sha1(uniqid(mt_rand(), true))).'.'.$request->$item_name->extension();
                $request->$item_name->storeAs($path, $new_file);
                $value_array[] = $new_file;

            }
            else if ($curriculum->$item_name != null)
            {

                $value_array[] = $curriculum->$item_name;

            }

        }

        for ($i = 0; $i < 5; $i++)
        {

            $item_name = $field_name.($i+1);
            if ($i < count($value_array))
            {

                $curriculum->$item_name = $value_array[$i];

            }
            else
            {

                $curriculum->$item_name = null;

            }

        }

        return $curriculum;

    }

    /**
     * カリキュラムの保存
     * @param  CurriculumRequest  $request
     * @param  Curriculum
     * @param  String $field_name
     * @param  String $path
     */
    public function saveFile(CurriculumRequest $request, Curriculum $curriculum, String $field_name, String $path)
    {

        $new_file = md5(sha1(uniqid(mt_rand(), true))).'.'.$request->$field_name->extension();
        $curriculum->$field_name = $new_file;
        $request->$field_name->storeAs($path, $new_file);

        return $curriculum;

    }

    /**
     * カリキュラムの保存
     * @param  CurriculumRequest  $request
     * @param  Curriculum
     */
    public function save(CurriculumRequest $request, Curriculum $curriculum)
    {

        $curriculum->curriculum_name_admin = $request->curriculum_name_admin;
        $curriculum->curriculum_name = $request->curriculum_name;
        $curriculum->category_id = $request->category_id;

        if ($request->hasFile('curriculum_image'))
        {

            $curriculum = $this->saveFile($request, $curriculum, 'curriculum_image', config('const.CURRICULUM_IMAGE_DIR_PATH'));

        }

        $curriculum->curriculum_type = $request->curriculum_type;
        if ($request->curriculum_type == '1')
        {

            $curriculum->movie_url = $request->movie_url;

        }

        if ($request->curriculum_type == '2')
        {

            if (!$request->has('audio_file_keeping'))
            {

                $curriculum = $this->saveFile($request, $curriculum, 'audio_file', config('const.AUDIO_DIR_PATH'));

            }

        }

        $curriculum = $this->saveItem($request, $curriculum, 'pdf_file', config('const.PDF_DIR_PATH'));

        $curriculum->authority_ranks = $request->authority_ranks;
        $curriculum->curriculum_text = $request->curriculum_text;
        $curriculum->is_required = $request->is_required;
        $curriculum->release_type = $request->release_type;
        $curriculum->released_at = $request->released_at;
        $curriculum->closed_at = $request->closed_at;
        $curriculum->released_date_count = $request->released_date_count;
        if ($request->released_date_count == 'null')
        {

            $curriculum->released_date_count = 0;

        }
        $curriculum->released_time = $request->released_time;
        $curriculum->closed_date_count = $request->closed_date_count;
        if ($request->closed_date_count == 'null')
        {

            $curriculum->closed_date_count = 0;

        }
        $curriculum->closed_time = $request->closed_time;

        $curriculum->save();

    }

    /**
     * カリキュラムの削除
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function destroy(Request $request)
    {

        $curriculum = Curriculum::where('curriculum_slug', $request->curriculum_slug)->first();
        $curriculum->status = 'D';
        $curriculum->deleted_at = date('Y-m-d H:i:s');
        $curriculum->save();

    }

    /**
     * カリキュラムの復帰
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function recover(Request $request)
    {

        $curriculum = Curriculum::where('curriculum_slug', $request->curriculum_slug)->first();
        $curriculum->status = 'A';
        $curriculum->deleted_at = null;
        $curriculum->save();

    }

    /**
     * カリキュラムのデータ取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Curriculum
     */
    public function show(Request $request)
    {

        $query = Curriculum::query();
        if ($request->mode === 'open')
        {

            $query->selectRaw("
                        *,
                        CASE
                            WHEN release_type = 1 then 1
                            WHEN release_type = 2 AND released_at <= NOW() AND closed_at >= NOW() THEN 1
                            ELSE 0
                        END as is_term
                    ");

        }

        if ($request->mode === 'user')
        {

            $created_timestamp = new \DateTime($request->created_at);
            $query->selectRaw("
                        *,
                        CASE
                            WHEN release_type = 1 then 1
                            WHEN release_type = 2 AND released_at <= NOW() AND closed_at >= NOW() THEN 1
                            ELSE 0
                        END as is_term,
                        CASE
                            WHEN released_date_count = 0 AND released_time is null AND closed_date_count = 0 AND closed_time is null THEN 1
                            WHEN DATE_ADD(? , INTERVAL concat(released_date_count, ' ', released_time) DAY_SECOND) <= now() AND DATE_ADD(? , INTERVAL concat(closed_date_count, ' ', closed_time) DAY_SECOND) >= now() THEN 1
                            ELSE 0
                        END as is_limited_user
                    ", [$created_timestamp->format('Y-m-d 00:00:00'), $created_timestamp->format('Y-m-d 00:00:00')]);

        }

        return $query->where('curriculum_slug', $request->curriculum_slug)->
                        first();

    }

    /**
     * カリキュラムのディレクトリ取得
     *
     * @return JSON
     */
    public function getDirectoryPath()
    {

        return response()->json(
        [
            'audio_path' => env('APP_URL').config('const.AUDIO_DIR_PATH'),
            'pdf_path' => env('APP_URL').config('const.PDF_DIR_PATH'),
            'image_path' => env('APP_URL').config('const.CURRICULUM_IMAGE_DIR_PATH'),
            'no_image_path' => env('APP_URL').config('const.COMMON_DIR_PATH').'no-image.png',
        ]);

    }

    /**
     * カリキュラムの受講状況の保存
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function take(Request $request)
    {

        $taking_curriculum = TakingCurriculum::
                                where('user_id', $request->user_id)->
                                where('curriculum_slug', $request->curriculum_slug)->
                                where('content_id', $request->content_id)->
                                first();

        if ($taking_curriculum == null)
        {

            $taking_curriculum = new TakingCurriculum;
            $taking_curriculum->user_id = $request->user_id;
            $taking_curriculum->curriculum_slug = $request->curriculum_slug;
            $taking_curriculum->content_id = $request->content_id;
            $taking_curriculum->taking_curriculum_second = $request->second;
            $taking_curriculum->total_curriculum_second = $request->total_curriculum_second;
            $taking_curriculum->started_at = date('Y-m-d H:i:s');
            if ($request->has('status'))
            {

                $taking_curriculum->status = $request->status;
                if ($request->status == 'F')
                {

                    $taking_curriculum->status = 'F';
                    $taking_curriculum->completed_at = date('Y-m-d H:i:s');

                    if ($taking_curriculum->taking_curriculum_second > $taking_curriculum->total_curriculum_second)
                    {

                        $taking_curriculum->taking_curriculum_second = $taking_curriculum->total_curriculum_second;

                    }

                    if ($taking_curriculum->total_curriculum_second > $taking_curriculum->taking_curriculum_second)
                    {

                        $taking_curriculum->total_curriculum_second = $taking_curriculum->taking_curriculum_second;

                    }

                }

            }
            else
            {

                $taking_curriculum->status = 'N';

            }


            $taking_curriculum->save();

        }
        else
        {

            if ($taking_curriculum->completed_at == null)
            {

                $taking_curriculum->taking_curriculum_second = $request->second;
                if ($request->status == 'F')
                {

                    $taking_curriculum->status = 'F';
                    $taking_curriculum->completed_at = date('Y-m-d H:i:s');

                    if ($taking_curriculum->taking_curriculum_second > $taking_curriculum->total_curriculum_second)
                    {

                        $taking_curriculum->taking_curriculum_second = $taking_curriculum->total_curriculum_second;

                    }

                    if ($taking_curriculum->total_curriculum_second > $taking_curriculum->taking_curriculum_second)
                    {

                        $taking_curriculum->total_curriculum_second = $taking_curriculum->taking_curriculum_second;

                    }

                }

                $taking_curriculum->save();

            }

        }

    }

    /**
     * カリキュラムの受講状況の1件の取得
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getOneTakingCurriculum(Request $request)
    {

        return TakingCurriculum::where('user_id', $request->user_id)->
                                where('curriculum_slug', $request->curriculum_slug)->
                                where('content_id', $request->content_id)->
                                first();

    }

    /**
     * 対象となるカリキュラムの受講状況の全ての取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TakingCurriculum
     */
    public function getAllTakingCurriculumData(Request $request)
    {

        $query = TakingCurriculum::query();
        $query->
        join('curriculums', 'taking_curriculums.curriculum_slug', '=', 'curriculums.curriculum_slug')->
        join('categories', 'curriculums.category_id', '=', 'categories.category_id');

        if ($request->has('user_id'))
        {

            $query->where('taking_curriculums.user_id', $request->user_id);

        }

        if ($request->has('curriculum_name'))
        {

            $curriculum_ids = Curriculum::where('curriculum_name', 'like', '%'.$request->curriculum_name.'%')->
                                    where('status', 'A')->
                                    pluck('curriculum_id')->
                                    toArray();

            if (count($curriculum_ids) > 0)
            {

                $query->whereIn('curriculums.curriculum_id', $curriculum_ids);

            }
            else
            {
                $query->where('curriculums.curriculum_id', 0);
            }

        }

        if ($request->has('category_name'))
        {

            $category_ids = Category::where('category_name', 'like', '%'.$request->category_name.'%')->
                                    pluck('category_id')->
                                    toArray();

            if (count($category_ids) > 0)
            {


                $query->whereIn('categories.category_id', $category_ids);

            }
            else
            {

                $query->where('categories.category_id', 0);

            }

        }

        if ($request->has('curriculum_type'))
        {

            $query->where('curriculums.curriculum_type', $request->curriculum_type);

        }

        if ($request->has('is_required'))
        {

            $query->where('curriculums.is_required', $request->is_required);

        }

        if ($request->has('status'))
        {

            $query->where('taking_curriculums.status', $request->status);

        }

        if ($request->has('order_item'))
        {

            $query->orderBy('taking_curriculums.'.$request->order_item, $request->order_by);

        }
        else
        {

            $query->orderBy('taking_curriculums.started_at', 'ASC');

        }

        $curriculums = $query->selectRaw('
                            curriculums.curriculum_slug,
                            curriculums.curriculum_name,
                            categories.category_name,
                            curriculums.curriculum_type,
                            curriculums.is_required as is_required,
                            taking_curriculums.started_at,
                            taking_curriculums.completed_at,
                            taking_curriculums.taking_curriculum_second,
                            taking_curriculums.total_curriculum_second,
                            taking_curriculums.status
                        ')->
                        paginate(20);

        return $curriculums;

    }

    /**
     * 認定証の取得
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getCertificate(Request $request)
    {

        $certificate = Certificate::where('user_id', $request->user_id)->
                                    first();

        if ($certificate != null)
        {

            if ($certificate->status == 'R' && !$this->userRequiredCurriculumStatus($request))
            {

                $certificate->delete();
                return null;

            }

        }

        return $certificate;

    }

    /**
     * 認定証の申請処理
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function requestCertificate(Request $request)
    {

        $certificate = new Certificate;
        $certificate->user_id = $request->user_id;
        $certificate->status = 'R';
        $certificate->save();

    }

    /**
     * 認定証の更新
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateCertificate(Request $request)
    {

        $certificate = Certificate::where('user_id', $request->user_id)->
                                    first();
        $certificate->status = 'C';
        $certificate->certified_date = date('Y-m-d');
        $certificate->save();

    }

    /**
     * 必須のカリキュラムの受講状況の取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function getRequiredCurriculumStatus(Request $request)
    {

        return response()->json(
        [
            'result' => $this->userRequiredCurriculumStatus($request)
        ]);

    }

    /**
     * ユーザーの必須のカリキュラムの受講状況の取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function userRequiredCurriculumStatus(Request $request)
    {

        $ret = false;

        $user = User::find($request->user_id);

        $end_count = TakingCurriculum::
                    join('curriculums', 'taking_curriculums.curriculum_slug', '=', 'curriculums.curriculum_slug')->
                    where('taking_curriculums.user_id', $request->user_id)->
                    where('taking_curriculums.status', 'F')->
                    where('curriculums.is_required', 1)->
                    where('curriculums.status', 'A')->
                    where(function($query) use($user)
                    {
                        $query->where('curriculums.authority_ranks', 0)->
                                orWhere(function($query) use($user)
                                {
                                    $query->where('curriculums.authority_ranks', $user->user_rank)->
                                    orWhere('curriculums.authority_ranks', 'like', $user->user_rank.',%')->
                                    orWhere('curriculums.authority_ranks', 'like', '%,'.$user->user_rank.',%')->
                                    orWhere('curriculums.authority_ranks', 'like', '%,'.$user->user_rank);
                                });
                    })->
                    count();

        $required_count = Curriculum::where('is_required', 1)->
                                where('status', 'A')->
                                where(function($query) use($user)
                                {
                                    $query->where('authority_ranks', 0)->
                                            orWhere(function($query) use($user)
                                            {
                                                $query->where('authority_ranks', $user->user_rank)->
                                                orWhere('authority_ranks', 'like', $user->user_rank.',%')->
                                                orWhere('authority_ranks', 'like', '%,'.$user->user_rank.',%')->
                                                orWhere('authority_ranks', 'like', '%,'.$user->user_rank);
                                            });
                                })->
                                count();

        if ($required_count <= $end_count)
        {

            $ret = true;

        }

        return $ret;

    }


    /**
     * 修了証を申請したユーザーの取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Certificate
     */
    public function getRequestCertificate(Request $request)
    {

        return Certificate::selectRaw('
                        users.user_id,
                        users.user_name,
                        certificates.created_at
                    ')->
                    join('users', 'users.user_id', '=', 'certificates.user_id')->
                    where('certificates.status', 'R')->
                    where('users.status', 'A')->
                    paginate(20);

    }

    /**
     * ユーザーの達成情報の取得
     *
     * @param  \Illuminate\Http\Request  $request
     *2@return JSON
     */
    public function getUserAchievementInfo(Request $request)
    {

        $user = User::find($request->user_id);

        $total_completed = TakingCurriculum::
                    join('curriculums', 'taking_curriculums.curriculum_slug', '=', 'curriculums.curriculum_slug')->
                    where('taking_curriculums.user_id', $request->user_id)->
                    where('taking_curriculums.status', 'F')->
                    where('curriculums.is_required', 1)->
                    where('curriculums.status', 'A')->
                    count();

        $total_count = Curriculum::where('is_required', 1)->
                            where('status', 'A')->
                            where(function($query) use($user)
                            {
                                $query->where('authority_ranks', 0)->
                                        orWhere(function($query) use($user)
                                        {
                                            $query->where('authority_ranks', $user->user_rank)->
                                            orWhere('authority_ranks', 'like', $user->user_rank.',%')->
                                            orWhere('authority_ranks', 'like', '%,'.$user->user_rank.',%')->
                                            orWhere('authority_ranks', 'like', '%,'.$user->user_rank);
                                        });
                            })->
                            count();

        $completed_percent = 0;
        if ($total_count > 0)
        {

            $completed_percent = intval(($total_completed / $total_count) * 100);

        }

        return response()->json(
        [
            'total_count' => $total_count,
            'total_completed' => $total_completed,
            'completed_percent' => $completed_percent,
        ]);


    }

}
