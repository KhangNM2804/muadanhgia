<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DropzoneController extends Controller
{
    function index()
    {
        return view('upload.dropzone');
    }

    function upload(Request $request)
    {
        $image = $request->file('file');

        $imageName = $image->getClientOriginalName();
        preg_match('/([0-9]{6,16})/', $imageName, $matches);
        $imageName = $matches[0] . ".html";

        $image->move(storage_path('app/backup_file'), $imageName);

        return response()->json(['success' => $imageName]);
    }

    function fetch()
    {
        $images = Storage::disk('backup_file')->listContents('/', true);
        $output = view('upload.list', ['images' => $images])->render();
        echo $output;
    }

    function delete(Request $request)
    {
        if ($request->get('name')) {
            \File::delete(storage_path('app/backup_file/' . $request->get('name')));
        }
    }

    function renameall(Request $request)
    {
        $images = Storage::disk('backup_file')->listContents('/', true);
        foreach ($images as $key => $file) {
            preg_match('/([0-9]{6,16})/', $file['basename'], $matches);
            if (isset($matches[0])) {
                $imageName = $matches[0] . ".html";
                \File::move(storage_path('app/backup_file/') . $file['basename'], storage_path('app/backup_file/') . $imageName);
            }
        }
    }

    function removefiles($day)
    {
        collect(Storage::disk('backup_file')->listContents('/', true))
            ->each(function ($file) use($day){
                if ($file['type'] == 'file' && $file['timestamp'] < now()->subDays($day)->getTimestamp()) {
                    Storage::disk('backup_file')->delete($file['path']);
                }
            });
    }


    //phoi
    function phoi_index()
    {
        return view('upload_phoi.dropzone');
    }

    function phoi_upload(Request $request)
    {
        $image = $request->file('file');

        $imageName = $image->getClientOriginalName();
        preg_match('/([0-9]{6,16})/', $imageName, $matches);
        $imageName = $matches[0] . ".jpg";

        $image->move(storage_path('app/phoivia'), $imageName);

        return response()->json(['success' => $imageName]);
    }

    function phoi_fetch()
    {
        $images = Storage::disk('phoivia')->listContents('/', true);
        $output = view('upload.list', ['images' => $images])->render();
        echo $output;
    }

    function phoi_delete(Request $request)
    {
        if ($request->get('name')) {
            \File::delete(storage_path('app/phoivia/' . $request->get('name')));
        }
    }

    function phoi_renameall(Request $request)
    {
        $images = Storage::disk('phoivia')->listContents('/', true);
        foreach ($images as $key => $file) {
            preg_match('/([0-9]{6,16})/', $file['basename'], $matches);
            if (isset($matches[0])) {
                $imageName = $matches[0] . ".jpg";
                \File::move(storage_path('app/phoivia/') . $file['basename'], storage_path('app/phoivia/') . $imageName);
            }
        }
    }

    function phoi_removefiles($day)
    {
        collect(Storage::disk('phoivia')->listContents('/', true))
            ->each(function ($file) use($day){
                if ($file['type'] == 'file' && $file['timestamp'] < now()->subDays($day)->getTimestamp()) {
                    Storage::disk('phoivia')->delete($file['path']);
                }
            });
    }
}
