<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreProductsRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function upload(Request $request, $isCK = true)
    {

        if ($request->hasFile('upload')) {

            $file = $request->file('upload');

            $fileName = self::setFilename($file);
            $filePath = self::getfilePath();

            if ($isCK) {
                $file->move($filePath, $fileName);
                $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                $url = asset($filePath . $fileName);
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";

            } else {
                $response = "";
            }
            return $response;
        } else {
            return response()->json(['error' => 'Upload failed'], 400);
        }


    }

    public static function getfilePath()
    {
        $basePath = "uploads/";
        $destination = date('Y') . '/' . date('m');
        if (!is_dir($basePath . $destination)) {
            mkdir($basePath . $destination, 0777, true);
        }
        $filePath = $basePath . $destination . '/';
        return $filePath;
    }


    public static function setFilename($file)
    {
        $originName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $fileName = $fileName . '_' . time() . '.' . $extension;
        return $fileName;
    }

    protected function uploadMainImage($file)
    {
        $fileName = self::setFilename($file);
        $filePath = self::getfilePath();
        $file->move($filePath, $fileName);
        $url = asset($filePath . $fileName);
        $response = ['status' => 1, 'message' => 'Success', 'fileName' => $fileName];
        return $response;
    }
}
