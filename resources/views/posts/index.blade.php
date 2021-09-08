@extends('layouts.app')

@section('content')



<?php

if(isset($categories)){
    $title = $categories? implode(" | ",$categories)  : "Posts";
}

?>
<h1>{{$title??"Posts"}}</h1>
@if(!isset($categories))
    <div class="m-2">

    {!! Form::open(['action'=>'postController@show_categories','method'=>'POST','enctype'=>'multipart/form-data']) !!}
    @foreach ($tags as $tag)
    <div class="form-check form-check-inline m-2">

        {{Form::checkbox($tag->name,$tag->id,false,['class'=>'form-check-input ' ])}}
        {{Form::label('name',$tag->name,['class'=>'form-check-label m-1'])}}
    </div>
    @endforeach
    {{Form::submit('Filter',['class'=>'btn btn-outline-info'])}}
    {!! Form::close() !!}
    </div>



@endif


    <a class="nav-link btn btn-primary d-block  p-2"  href='/posts/create'>Create Post +</a>


    @if(count($posts)>0)


    @foreach($posts as $post)
        <div class='card card-body bg-light mt-3'>
            <div class='row'>
                <div class='col-md-4 col-sm-4'>
                    <img style='width :100%' src='/storage/cover_image/{{$post->cover_image}}'>
        </div>
            <div class='col-md-8 col-sm-8'>
                <h3><a href='../../posts/{{$post->id}}'>{{$post->title}}</a></h3>
                <small>Writen on {{$post->created_at}} by <i><b>{{$post->user->name}}</b></i></small>
                </div>
            </div>

        </div>

    @endforeach()

    @if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator )
    <div class='mt-3'>  {{$posts->links()}}</div>
    @endif

    @else
    <p>no posts found...!</p>
    @endif
@endsection()


