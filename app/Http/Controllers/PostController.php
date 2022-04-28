<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function Index(Request $request)
    {
    	$keyword = $request->input('keyword');
    	$query = Post::query();
    	if ($keyword) {
    		$query->where('title','like',"%{$keyword}%");
    	}

    	$query->orderBy('id','desc');
    	$posts = $query->paginate(2);


    	// $posts = Post::paginate(3);

    	return view('posts.index',compact('posts'));
    }


    public function create(){
    	return view('posts.create');
    }

    public function store(Request $request){

    	$title = $request->input('title');
    	$content = $request->input('content');
    	$status = $request->input('status');

    	$post = new Post;
    	$post->title = $title;
    	$post->content = $content;
    	$post->status = $status;

    	$post->save();
    	return redirect()->route('posts.index');
    }

    public function edit($id)
    {
    	$post = Post::find($id);
    	if (!$post) {
    		abort(404);
    	}
    	return view('posts.edit',compact('post'));
    }

    public function update($id , Request $request)
    {
    	$title = $request->input('title');
    	$content = $request->input('content');
    	$status = $request->input('status');

    	$post = Post::find($id);
    	$post->title = $title;
    	$post->content = $content;
    	$post->status = $status;

    	$post->save();
    	return redirect()->route('posts.index');
    }

    public function destroy($id)
    {
    	$post = Post::find($id);
    	$post->delete();
    	return redirect()->route('posts.index');
    }
}
