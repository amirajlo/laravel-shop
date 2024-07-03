<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;
use App\Http\Requests\StoreCommentsRequest;
use App\Http\Requests\UpdateCommentsRequest;
use App\Models\Comment;
use App\Models\Main;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminCommentsController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Comment::where(['is_deleted' => Main::STATUS_DISABLED])->get();
        return view('admin.comments.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.comments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentsRequest $request)
    {
        $request->merge([

            'user_id'=>Auth::user()->id,
        ]);

        Comment::create($request->all());
        return redirect()->route('admin.comments.index')->with('swal-success', 'کامنت جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comments $model)
    {
        return view('admin.comments.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $model)
    {
        return view('admin.comments.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentsRequest $request, Comment $model)
    {
        $request->merge([
            'user_id'=>Auth::user()->id,
        ]);
        $model->update($request->all());
        return redirect()->route('admin.comments.index')->with('swal-success', 'کامنت با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;

        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.comments.index')->with('swal-success', 'کامنت با موفقیت حذف شد');
    }

    public function status(Comment $model)
    {

        $outpot = ['status' => false, 'message' => "مشکلی در فرآیند به وجود آمده است."];
        if (in_array($model->status, [Main::STATUS_ACTIVE, Main::STATUS_DISABLED])) {
            $status = Main::STATUS_ACTIVE;
            if ($model->status == $status) {
                $status = Main::STATUS_DISABLED;
            }
            $model->status = $status;

            $result = $model->save();
            if ($result) {
                $outpot = ['status' => true, "message" => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }
        } else {
            $model->status = Main::STATUS_ACTIVE;

            $model->save();
            $outpot = ['status' => true, 'message' => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }
}
