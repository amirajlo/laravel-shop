<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Http\Requests\StoreArticlesRequest;
use App\Http\Requests\UpdateArticlesRequest;
use App\Models\Article;
use App\Models\Main;

use App\Models\ModelHasTag;
use App\Models\Tags;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminArticlesController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $condition = Main::defaultCondition();
        $models = Article::where($condition)->get();
        return view('admin.articles.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $condition = Main::defaultCondition();
        $tags = Tags::where($condition)->get();
        return view('admin.articles.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticlesRequest $request)
    {

        $is_commentable = Main::STATUS_DEFAULT;
        if ($request->has('is_commentable')) {
            $is_commentable = Main::STATUS_ACTIVE;
        }
        $request->merge([
            'is_commentable' => $is_commentable
        ]);


        $model = Article::create($request->except('tags'));
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $uploadmainImage = $this->uploadMainImage($file);

            if ($uploadmainImage['status'] == Main::STATUS_ACTIVE) {
                $model->sidebar = $uploadmainImage['fileName'];
                $model->save();
            }
        }
        if (is_array($request->tags)) {
            foreach ($request->tags as $tag) {
                $tagModel = Tags::where(['id' => (int)$tag])->first();
                if (!$tagModel) {
                    $tagModel = new Tags();
                    $tagModel->title = $tag;
                    $tagModel->save();
                }
                ModelHasTag::create([
                    'tag_id' => $tagModel->id,
                    'taggable_id' => $model->id,
                    'taggable_type' => get_class($model),
                ]);
            }
        }



        $request->merge([
            'slug' => Str::slug($request->title, '-', null),
            'author_id' => Auth::user()->id,

        ]);
        return redirect()->route('admin.articles.index')->with('swal-success', 'مقاله جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $model)
    {
        return view('admin.articles.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $model)
    {
        $condition = Main::defaultCondition();
        $tags = Tags::where($condition)->get();


        return view('admin.articles.edit', compact('model', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticlesRequest $request, Article $model)
    {

        if (is_array($request->tags)) {
            foreach ($request->tags as $tag) {
                $tagModel = Tags::where(['title' => $tag])->first();
                if ($tagModel) {

                } else {
                    $tagModel = new Tags();
                    $tagModel->title = $tag;
                    $tagModel->save();
                }
            }
        }

        $is_commentable = Main::STATUS_DEFAULT;
        if ($request->has('is_commentable')) {
            $is_commentable = Main::STATUS_ACTIVE;
        }

        $request->merge([
            'slug' => Str::slug($request->title, '-', null),
            'author_id' => Auth::user()->id,
            'is_commentable' => $is_commentable,
        ]);

        $model->update($request->except('tags'));
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $uploadmainImage = $this->uploadMainImage($file);

            if ($uploadmainImage['status'] == Main::STATUS_ACTIVE) {
                $model->sidebar = $uploadmainImage['fileName'];
                $model->save();
            }
        }
        return redirect()->route('admin.articles.index')->with('swal-success', 'مقاله با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;
        $model->author_id = Auth::user()->id;
        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.articles.index')->with('swal-success', 'مقاله با موفقیت حذف شد');
    }

    public function status(Article $model)
    {

        $outpot = ['status' => false, 'message' => "مشکلی در فرآیند به وجود آمده است."];
        if (in_array($model->status, [Main::STATUS_ACTIVE, Main::STATUS_DISABLED])) {
            $status = Main::STATUS_ACTIVE;
            if ($model->status == $status) {
                $status = Main::STATUS_DISABLED;
            }
            $model->status = $status;
            $model->author_id = Auth::user()->id;
            $result = $model->save();
            if ($result) {
                $outpot = ['status' => true, "message" => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }
        } else {
            $model->status = Main::STATUS_ACTIVE;
            $model->author_id = Auth::user()->id;
            $model->save();
            $outpot = ['status' => true, 'message' => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }


}
