<?php

namespace App\Http\Controllers;


use App\Post;
use App\User;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\PostRequest;
use App\Http\Requests\CommentRequest;
use Intervention\Image\ImageManagerStatic as Image;
use DB;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::orderBy('created_at','desc')->simplePaginate(5);
        return view('index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check()){
            return  view('form');
            }else{
             return view('error');
            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if(Auth::check()){
        $post=new Post;
        $post->user_id=Auth::user()->id;
        $post->name=Auth::user()->name;
        $post->title=$request->title;
        $post->article=nl2br($request->article);
        if ($request->hasFile('image')) {
         $image=$request->file('image');
         $id=Auth::user()->id;
         $name=date('YmdHis').$id.'.'.$image->getClientOriginalExtension();
         Storage::disk('public')->putFileAs('/images', $image, $name);
         $img_resize=Image::make(storage_path('/app/public/images/'.$name))
                    ->resize(500,320)
                    ->save(storage_path('/app/public/images/'.$name));
         $post->image='/images/'.$name;
        }
        $post->post_time=date('F t, Y').' at '.date('g:iA');
        $post->save();
        return redirect()->route('index');
        }else{
        return view('error');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show=Post::findorfail($id);
         return view('show',compact('show'));
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->id == Post::find($id)->user_id){
        $post=Post::where('id',$id)->get();
        return view('edit', compact('post'));
        }else{
            return view('error');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request)
    {
        $post=Post::find($request->id);
        $post->title=$request->title;
        $post->article=nl2br($request->article);
        if ($request->hasFile('image')) {
            $image=$request->file('image');
            $id=Auth::user()->id;
            $name=date('YmdHis').$id.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('/images', $image, $name);
            $img_resize=Image::make(storage_path('/app/public/images/'.$name))
                       ->resize(500,320)
                       ->save(storage_path('/app/public/images/'.$name));
            $post->image='/images/'.$name;
           }else{
            Storage::disk('public')->delete(Post::find($request->id)->image);   
            $post->image=$request->del_image;    
           }
       
        $post->save();
        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            if(Auth::user()->id == Post::find($id)->user_id){
            Storage::disk('public')->delete(Post::find($id)->image);
            Post::where('id',$id)->delete();
            return;
            }else{
                return view('error');
            }
    }

    public function comment(CommentRequest $request)
    {
        if(Auth::check()){
        DB::table('comments')->insert(
            [
                'user_id'=>Auth::user()->id,
                'post_id'=>$request->post_id,
                'name'=>Auth::user()->name,
                'comment'=>$request->comment,
                'c_time'=>date('F t, Y').' at '.date('g:iA'),
                'ip'=>$request->ip(),
            ]);
            return redirect()->back();
        }else{
            DB::table('comments')->insert(
                [
                    'post_id'=>$request->post_id,
                    'name'=>'訪客',
                    'comment'=>$request->comment,
                    'c_time'=>date('F t, Y').' at '.date('g:iA'),
                    'ip'=>$request->ip(),
                ]);
            return redirect()->back();
        }    
            
    }

    public function search(Request $request)
    {
        $keyword=$request->keyword;
        $search=Post::where('title','like','%'.$keyword.'%')
                     ->orwhere('name','like','%'.$keyword.'%')
                     ->orwhere('article','like','%'.$keyword.'%')
                     ->get();
        return view ('search', compact('search'));
        
    }

    public function name($name)
    {
        $names=Post::where('name',$name)->get();
        return view('name',compact('names'),['writer'=>$name]);
    }
    
}
