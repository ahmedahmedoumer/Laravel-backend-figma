<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class storageController extends Controller
{
    //
    public function getFile($fileName){
        $path = storage_path('app/public/' . $fileName);
    
        if (!File::exists($path)) {
            abort(404);
        }
    
        $file = File::get($path);
        $type = File::mimeType($path);
         return response($file, 200, ['Content-Type',$type]);
    //    $response=Response::make($file, 200);
    //    $response->header('Content-Type',$type);
    //    return $response;
   }
}
