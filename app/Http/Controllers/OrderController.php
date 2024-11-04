<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTypeRequest;
use App\Models\Type;
use App\Models\TypeOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    // public function index()
    // {
    //     $types = Type::all();
    //     return view('type.index', compact('types'));
    // }

    public function create($path)
    {
        $type = TypeOrder::where('path', $path)->get();
        return view('orders.create', compact('type'));
    }
    public function store(Request $request)
    {
        $files_icon = [];
        return redirect()->back();
    }
}
