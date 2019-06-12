<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function imageList(){
        return response()->download(public_path('user.png') , 'User Image');
    }

    public function imageSave(Request $request){
        $fileName = time().'.jpg';
        $path = $request->file('photo')->move(public_path('/'), $fileName);
        $photoUrl = url('/'.$fileName);
        return response()->json(['url'=> $photoUrl],200);
    }
}
