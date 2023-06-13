<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
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
   }

   public function downloadSourceFile(Request $request){
    $sourceFile=$request->query('fileName');
    $filePath=storage_path('app/public/sourceFiles/'.$sourceFile);
    if (file_exists($filePath)) {
        return response()->download($filePath);
    }
    return "hello";
     
   }
}
