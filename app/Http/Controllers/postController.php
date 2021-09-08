<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\post;
use App\Comment;
use App\PostTag;
use App\Tag;
use App\User;

use function PHPSTORM_META\map;

class postController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=>['index,show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts= post::orderBy('created_at','desc')->paginate(4);
        $tags= Tag::all();


        return view('posts.index')->with(['posts'=>$posts,'tags'=>$tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories= Tag::all();


        // $categories=['sport','science','programmin','ai'];
        return view('posts.create')->with('tags',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tags= Tag::all();
        $tagsName= array();
        foreach($tags as $tag){
            array_push($tagsName,$tag->name);
        }

        $sellectedTags= array();
        $req=$request->all();
        foreach($tagsName as $singleTag){
            if(array_key_exists($singleTag,$req)){
                array_push($sellectedTags,$req[$singleTag]);
            }
        }

        $this->validate($request,[
            'title'=> 'required',
            'body'=>'required',
            'cover_image'=>'image|nullable|max:1999'
        ]);


            if ($request->hasFile('cover_image')){
                $fileNameWithExt=$request->file('cover_image')->getClientOriginalName();
                $filename=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                $extension=$request->file('cover_image')->getClientOriginalExtension();
                $fileNameToSave=$filename.'_'.time().'.'.$extension;
                $path=$request->file('cover_image')->storeAs('public/cover_image',$fileNameToSave);
            }else{
                $fileNameToSave='noimage.jpg';


            }

        $post=new post();
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        $post->user_id=auth()->user()->id;
        $post->cover_image=$fileNameToSave;
        $post->save();

        foreach($sellectedTags as $toBeAdd){
            $post_tag= new PostTag();
            $post_tag->post_id=$post->id;
            $post_tag->tag_id=$toBeAdd;
            $post_tag->save();
        }



        return redirect('/posts')->with(['success'=>'one post has submited','tags'=>$tags]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post= post::find($id);
        $comments= Comment::where('post_id', $id)->get();

        return view('posts.show')->with(['post'=>$post,'comments'=>$comments]);
    }

    public function show_categories(Request $request){
        $tags= Tag::all();
        $tagsName= array();
        foreach($tags as $tag){
            array_push($tagsName,$tag->name);
        }

        $sellectedTags= array();
        $req=$request->all();
        foreach($tagsName as $singleTag){
            if(array_key_exists($singleTag,$req)){
                array_push($sellectedTags,$req[$singleTag]);
            }
        }

        $posts= Tag::with('posts')->whereIn('id',$sellectedTags)->get();

        $newposts=array();
        $categories=array();
        foreach($posts as $subposts){
            array_push($categories,$subposts->name);
            foreach($subposts->posts as $singlpost){
            if (! isset($newposts[$singlpost->id])) {
                $newposts[$singlpost->id]= $singlpost;
            }
        }
        }
        return view('../../posts.index')->with(['categories'=>$categories,'posts'=>$newposts]);


    }


    public function array_flatten($array,$return) {
        for($x = 0; $x <= count($array); $x++) {
            if(is_array($array[$x])) {
                $return = $this->array_flatten($array[$x], $return);
            }
            else {
                if(isset($array[$x])) {
                    $return[] = $array[$x];
                }
            }
        }
        return $return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post= post::find($id);
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
        $this->validate($request,[
            'title'=> 'required',
            'body'=>'required',
            'cover_image'=>'image|nullable|max:1999'
        ]);
        if ($request->hasFile('cover_image')){
                $fileNameWithExt=$request->file('cover_image')->getClientOriginalName();
                $filename=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                $extension=$request->file('cover_image')->getClientOriginalExtension();
                $fileNameToSave=$filename.'_'.time().'.'.$extension;
                $path=$request->file('cover_image')->storeAs('public/cover_image',$fileNameToSave);
        }

        $post= post::find($id);
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        if ($request->hasFile('cover_image')){
            $post->cover_image=$fileNameToSave;
        }
        $post->save();

        return redirect('/posts')->with('success','one post has updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= post::find($id);
        if($post->cover_image!='noimage.jpg'){
            Storage::delete('public/cover_image/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success','one post has deleted');
    }
}
