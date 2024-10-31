<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTypeRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TypeController extends Controller
{
    public function index(){
        $types = Type::all();
        return view('type.index', compact('types'));
    }

    public function create(){
        $path = public_path('assets/media/country');
        $files_icon = File::allFiles($path);
        return view('type.create',compact('files_icon'));
    }

    public function post_create(CreateTypeRequest $request){
        Type::create($request->all());
        return redirect()->route('type.index')->with('success','Tạo danh mục thành công!');
    }

    public function edit($id){
        $getType = Type::find($id);
        if(empty($getType)){
            abort(404);
        }
        $path = public_path('assets/media/country');
        $files_icon = File::allFiles($path);
        return view('type.edit', compact('getType','files_icon'));
    }


    public function post_edit(CreateTypeRequest $request, $id){
        $dataUpdate = $request->all();
        unset($dataUpdate['_token']);
        if(!isset($dataUpdate['display'])){
            $dataUpdate['display'] = 0;
        }
        Type::where("id",$id)
                    ->update($dataUpdate);
        return redirect()->route('type.index')->with('success','Chỉnh sửa danh mục thành công!');
    }
}
