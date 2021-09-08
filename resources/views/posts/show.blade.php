
@extends('layouts.app')


@section('content')
<div class="btn-con">
    <div class="backBtn ">
        <span class="line tLine"></span>
        <span class="line mLine"></span>
        <a class="link" href='/posts'>
        <span class="label">Back</span>
    </a>
        <span class="line bLine"></span>
    </div>
</div>


    <?php $post = $post ?? Session::get('post'); ?>

    <h1>{{$post->title }}</h1>

    <div class='card card-body bg-light '>
    <p class='h4'> {!!$post->body !!}</p>
    <img style='width :100%' src='/storage/cover_image/{{$post->cover_image}}'>
    <small>Writen on {{$post->created_at}}</small>

    </div>
    <hr>
    @if(Auth::check())
    @if($post->user_id==auth()->user()->id)
    <a href='\posts\{{$post->id}}\edit' class='btn btn-success'>Edit</a>
    {!!Form::open(['action'=>['postController@destroy',$post->id],'method'=>'POST','class'=>'float-right'])!!}
    {{Form::hidden('_method','DELETE')}}
    {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
    {!!Form::close()!!}
    @endif
    @endif

    <hr>
    @if(count($comments)>0)
    @foreach ($comments as $comment)
    <ul class="list-group">
        <li class="list-group-item">
            <p class='h6'>  {!!$comment->body !!}</p>
            <small>Writen on {{$comment->created_at}} </small>
        </li>
    </ul>

    @endforeach
    @endif

    {!! Form::open(['action'=>['commentsController@update',$post->id],'method'=>'POST','enctype'=>'multipart/form-data']) !!}

    <div class='form-group'>
        {{Form::label('body','write a comment')}}
        {{Form::textarea('body','',['rows'=>'1', 'class'=>'form-control ','placeholder'=>'write a comment','id'=>'mytextarea'])}}
    </div>
    {{Form::hidden('_method','PUT')}}
    {{Form::submit('Add comment',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}



@endsection()
