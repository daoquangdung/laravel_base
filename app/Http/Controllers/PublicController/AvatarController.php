<?php

namespace App\Http\Controllers\PublicController;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class AvatarController extends Controller
{
    //
    public function avatar($id,$filename){
        $path = storage_path('app/avatar/'.$id.'/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
