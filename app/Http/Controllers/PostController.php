<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function __construct(){

        $this->middleware('auth')->except(['index', 'show']);

    }

    public function index()
    {
        $posts = Post::with('user')->orderBy('updated_at','DESC')->paginate(5);

        return view('posts.index', [ 'posts' => $posts ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store( Request $request )
    {
        
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $request->user()->posts()->create($request->only('title', 'body'));

        return redirect()->route('posts.index');
    }

    public function show( Post $post )
    {
        return view('posts.show', [ 'post' => $post ]);
    }

    public function edit( Post $post )
    {
        return view('posts.edit', [ 'post' => $post ]);
    }

    public function update( Request $request, Post $post )
    { 
        if ( Gate::denies('update-post', $post)) {
            abort(403);
        }
    
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $post->update($request->only('title', 'body'));

        return redirect()->route('posts.index');;
    }

    public function destroy( Request $request, Post $post )
    {
        if ( Gate::denies('update-post', $post)) {
            abort(403);
        }

        $post->delete();

        return back();
    }
}
