<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;
use DB;
class Delivery extends Main
{
    use HasFactory;


    protected $fillable = [

        'title',
        'description',
        'status',
        'author_id',
        'main_image',
        'fee',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public  static function deliveryList()
    {
        //$models = Delivery::select(["id", "title",'fee'])->where(['is_deleted' => Main::STATUS_DISABLED])->get();
        $models =  DB::table('deliveries')
            ->select("id", "title",'fee')
            ->where(['is_deleted' => Main::STATUS_DISABLED])
            ->get();
        $data=[];
        foreach ($models as $model){
            $data[$model->id]=$model->title." ".$model->fee;
        }
        return $data;
    }
}
