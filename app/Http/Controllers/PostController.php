<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderby('id','DESC')->paginate(15);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$request->validate([
            'title'=> 'required|max:255',
            'body'=> 'required',
        ]);

        $dataPost = $request->all();
        $dataPost['slug'] = SlugService::createSlug(Post::class, 'slug', $dataPost['title']);
        Post::create($request->all());

        return redirect()->route('posts');
    }

    public function getEdit(Request $request,$id)
    {
    	$post = Post::find($id);
        return view('posts.edit', compact('post'));
    }

    public function postEdit(Request $request,$id)
    {
        $request->validate([
            'title'=> 'required|max:255',
            'body'=> 'required',
        ]);
        $dataUpdate = $request->all();
        unset($dataUpdate['_token']);
        if(!isset($dataUpdate['public'])){
            $dataUpdate['public'] = 0;
        }
        if(!isset($dataUpdate['is_comment'])){
            $dataUpdate['is_comment'] = 0;
        }
        if(!isset($dataUpdate['pin'])){
            $dataUpdate['pin'] = 0;
        }
        if(!isset($dataUpdate['coin_flg'])){
            $dataUpdate['coin_flg'] = 0;
        }
        if(!isset($dataUpdate['valid_coin'])){
            $dataUpdate['valid_coin'] = 0;
        }
        $dataUpdate['slug'] = SlugService::createSlug(Post::class, 'slug', $dataUpdate['title']);
    	Post::where("id",$id)
                    ->update($dataUpdate);
        return redirect()->route('posts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
    	$post = Post::where('slug', $slug)->first();
        abort_if(empty($post), 404);
        return view('posts.show', compact('post'));
    }
    public function delete($id)
    {
    	$post = Post::find($id);
        $post->delete();
        return redirect()->route('posts');
    }
}
