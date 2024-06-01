<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticlesRequest;
use App\Http\Requests\UpdateArticlesRequest;
use App\Models\Article;
use App\Models\Main;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Article::where(['is_deleted' => Main::STATUS_DEFAULT])->get();
        return view('admin.articles.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticlesRequest $request)
    {
        $request->merge([
            'slug' => Str::slug($request->title, '-', null),
            'author_id'=>Auth::user()->id,
        ]);

        Article::create($request->all());
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
        return view('admin.articles.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticlesRequest $request, Article $model)
    {
        $request->merge([
            'slug' => Str::slug($request->title, '-', null),
            'author_id'=>Auth::user()->id,
        ]);
        $model->update($request->all());
        return redirect()->route('admin.articles.index')->with('swal-success', 'مقاله با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $model)
    {
        $model->is_deleted = Main::STATUS_IS_DELETED;
        $model->author_id =Auth::user()->id;
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
            $model->author_id =Auth::user()->id;
            $result = $model->save();
            if ($result) {
                $outpot = ['status' => true, "message" => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }
        } else {
            $model->status = Main::STATUS_ACTIVE;
            $model->author_id =Auth::user()->id;
            $model->save();
            $outpot = ['status' => true, 'message' => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }
}
