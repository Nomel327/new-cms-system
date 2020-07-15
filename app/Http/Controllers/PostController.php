<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    //

    public function index(){

        // $posts = Post::all();
        $posts = auth()->user()->posts()->paginate(5);
        return view('admin.posts.index', ['posts'=> $posts]);
    }

    public function show(Post $post){

        return view('blog-post', ['post'=> $post]);
    }

    public function create(){

        $this->authorize('create', Post::class);

        return view('admin.posts.create');
    }

    public function store(){
        
        $this->authorize('create', Post::class);

        // dd(request()->all());
        
        $inputs = request()->validate([
            'title'=> 'required|min:8|max:255',
            'post_image'=> 'file',
            'body'=> 'required'
        ]);
            
        if(request('post_image')){
            $inputs['post_image'] = request('post_image')->store('images');
        }

        auth()->user()->posts()->create($inputs);

        session()->flash('post-created-message', 'Post was Created'. $inputs['title']);

        return redirect()->route('post.index');
    }


    public function edit(Post $post){

        $this->authorize('view', $post);
        
        // if(auth()->user()->can('view', $post)){

        // }

        return view('admin.posts.edit', ['post'=> $post]);
    }


    public function destroy(Post $post, Request $request){
        
        $this->authorize('delete', $post);

        $post->delete();

        $request->session()->flash('message', 'Post was Deleted');

        return back();
    }

    public function update(Post $post){

        $inputs = request()->validate([
            'title'=> 'required|min:8|max:255',
            'post_image'=> 'file',
            'body'=> 'required'
        ]);
            
        if(request('post_image')){
            $inputs['post_image'] = request('post_image')->store('images');
            $post->post_image = $inputs['post_image'];
        }

        $post->title = $inputs['title'];
        $post->body = $inputs['body'];

        $this->authorize('update', $post);

        // ユーザー名も更新される
        // auth()->user()->posts()->save($post);

        // 投稿を上書き保存
        $post->save();

        // 投稿を更新
        // $post->update();

        session()->flash('post-updated-message', 'Post was Updated'. $inputs['title']);

        return redirect()->route('post.index');
    }
}
