<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

use App\Models\Category;

use Validator;
use Log;

class CategoriesController extends Controller
{

    /**
     * カテゴリーのデータ一覧取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Category
     */
    public function getAllCategoryData(Request $request)
    {

        $query = Category::query();
        if ($request->has('category_name_admin'))
        {

            $query->where('category_name_admin', 'like', '%'.$request->category_name_admin.'%');

        }

        if ($request->has('category_name'))
        {

            $query->where('category_name', 'like', '%'.$request->category_name.'%');

        }

        if ($request->has('category_level'))
        {

            $query->where('category_level', $request->category_level);

        }

        if ($request->has('parent_category_name'))
        {

            $category_ids = Category::where('category_level', 'P')->
                                    where('category_name', 'like', '%'.$request->parent_category_name.'%')->
                                    pluck('category_id')->
                                    toArray();

            if (count($category_ids) > 0)
            {

                $query->whereIn('parent_id', $category_ids);

            }
            else
            {

                $query->where('parent_id', 0);

            }

        }

        if ($request->has('status'))
        {

            $query->where('status', $request->status);

        }

        $categories = $query->selectRaw("
                                *,
                                CASE
                                    WHEN parent_id is null then category_id
                                    ELSE parent_id
                                END AS group_id
                            ")->
                            orderBy('group_id', 'ASC')->
                            orderBy('category_id', 'ASC')->
                            paginate(20);

        return $categories;

    }

    /**
     * 親カテゴリーの取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Category
     */
    public function getParentCategories(Request $request)
    {

        $ret = array();

        $query = Category::query();
        if ($request->has('is_active_only'))
        {

            $query->where('status', 'A');

        }
        $categories = $query->where('category_level', 'P')->
                            get();

        if ($categories != null)
        {

            foreach ($categories as $category)
            {

                $ret[] = array(
                    'key' => $category->category_id,
                    'value' => $category->category_name,
                );

            }

        }

        return response()->json([
            'categories' => $ret
        ]);

    }

    /**
     * 有効な全てのカテゴリーの取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Category
     */
    public function getActiveCategories(Request $request)
    {

        $ret = array();

        $categories = Category::selectRaw("
                                category_id,
                                category_name,
                                CASE
                                    WHEN parent_id is null then category_id
                                    ELSE parent_id
                                END AS group_id
                            ")->
                            where('status', 'A')->
                            orderBy('group_id', 'ASC')->
                            orderBy('category_id', 'ASC')->
                            get();

        if ($categories != null)
        {

            foreach ($categories as $category)
            {

                $ret[] = array(
                    'key' => $category->category_id,
                    'value' => $category->category_name,
                );

            }

        }

        return response()->json([
            'categories' => $ret
        ]);

    }

    /**
     * カテゴリーの新規登録
     *
     * @param  CategoryRequest  $request
     * @return JSON
     */
    public function store(CategoryRequest $request)
    {

        $category = new Category;
        $category->category_slug = md5(sha1(uniqid(mt_rand(), true)));
        $this->save($request, $category);

        return response()->json(
        [
            'success' => true
        ]);

    }

    /**
     * カテゴリーの更新登録
     *
     * @param  CategoryRequest $request
     * @return JSON
     */
    public function update(CategoryRequest $request)
    {

        $category = Category::find($request->category_id);

        if ($request->has('category_image_change'))
        {

            $file = public_path(config('const.CATEGORY_DIR_PATH').$category->category_image);
            unlink($file);
            $category->category_image = null;
            $category->save();

        }

        $this->save($request, $category);

        return response()->json(
        [
            'success' => true
        ]);

    }

    /**
     * カテゴリーの保存
     * @param  CategoryRequest $request
     * @param  Category
     */
    private function save(CategoryRequest $request, Category $category)
    {

        $category->category_name_admin = $request->category_name_admin;
        $category->category_name = $request->category_name;
        $category->category_level = $request->category_level;
        if ($request->parent_id != 'null')
        {
            $category->parent_id = $request->parent_id;
        }
        $category->category_text = $request->category_text;

        if ($request->hasFile('category_image'))
        {

            $new_file = md5(sha1(uniqid(mt_rand(), true))).'.'.$request->category_image->extension();
            $category->category_image = $new_file;
            $request->category_image->storeAs(config('const.CATEGORY_DIR_PATH'), $new_file);

        }

        $category->save();

    }

    /**
     * カテゴリーの削除
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function destroy(Request $request)
    {

        $category = Category::find($request->category_id);
        $category->status = 'D';
        $category->deleted_at = date('Y-m-d H:i:s');
        $category->save();

    }

    /**
     * カテゴリーの復帰
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function recover(Request $request)
    {

        $category = Category::find($request->category_id);
        $category->status = 'A';
        $category->deleted_at = null;
        $category->save();

    }

    /**
     * カテゴリーのデータ取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Category
     */
    public function show(Request $request)
    {

        return Category::find($request->category_id);

    }

    /**
     * カテゴリー画像のディレクトリ取得
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function getDirectoryPath(Request $request)
    {

        return env('APP_URL').config('const.CATEGORY_DIR_PATH');

    }

}
