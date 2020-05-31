<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Arr; 

class PostsController extends Controller
{
       /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' =>['index','show']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //$posts = Post::orderBy('created_at','desc')->get();
        $posts = Post::orderBy('created_at','desc')->paginate(5);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $cat = Category::all();
        if(auth()->user()->role !== 'administrator'){
            return redirect('/posts')->with('error', 'Unauthorized action');
        }
        return view('posts.create',['cat'=>$cat]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            // 'category_id'=>'required'
        ]);


        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        // $post->user_id = Auth()->user()->id;
        $post->user_id = Auth::id();
        $post->slug = Str::slug($request->title, '-', "ja");
        $post->save();

        return redirect('/posts')->with('success','Post Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    public function show(Post $post)
    {
        // $post =Post::find($id);
        //showページで同じカテゴリーのリストを表示する時に使用するcode
        $post_cat_id = $post->category_id;
        $same_category_posts = Post::where('category_id',$post_cat_id)->orderBy('id','asc')->get();
        return view('posts.show ')->with('post', $post)->with('same_category_posts',$same_category_posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post =Post::find($id);
        //Check for correct user
        // if(auth()->user()->id !== $post->user_id){
        //     return redirect('/posts')->with('error','Unauthorized Page');
        // }
        if(auth()->user()->role !== 'administrator'){
            return redirect('/posts')->with('error', 'Unauthorized action');
        }  
        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $validatedData = request()->validate([
            'title'=>'required',
            'body'=>'required',
            // 'category_id'=>'required'
        ]);

        $post = Post::findOrFail($id);
        // $post->category_id = request('category_id');
        $post->title = request('title');
        $post->slug = Str::slug($request->title,'-',"ja");
        $post->body = request('body');
        $post->modified_at = Carbon::now();
        $post->update();

        return redirect('/posts')->with('success','Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        //Check for correct user
        // if(auth()->user()->id !== $post->user_id){
        //     return redirect('/posts')->with('error','Unauthorized Page');
        // }
        if(Auth::user()->role !== 'administrator'){
            return redirect('/posts')->with('error', 'Unauthorized action');
           }
        $post->delete();
        return redirect('/posts')->with('success','Post Removed');
    }
}
