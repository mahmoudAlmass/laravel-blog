@extends('layouts.app')

@section('content')

  <h1>Create Post</h1>
  {!! Form::open(['action'=>'postController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
    <div class='form-group'>
     {{Form::label('title','Title')}}
     {{Form::text('title','',['class'=>'form-control','placeholder'=>'Title'])}}
    </div>

    <div class='form-group'>
     {{Form::label('body','Body')}}
     {{Form::textarea('body','',['class'=>'form-control ','placeholder'=>'Body','id'=>'mytextarea'])}}
    </div>
    <div class='form-group'>
    {{Form::file('cover_image')}}
    </div>

    <div class='form-group'>
    <hr>
    {{Form::label('categories','Categories: ')}}

    @foreach ($tags as $tag)
    <div class="form-check form-check-inline m-2">

        {{Form::checkbox($tag->name,$tag->id,false,['class'=>'form-check-input ' ])}}
        {{Form::label('name',$tag->name,['class'=>'form-check-label m-1'])}}
    </div>
    @endforeach
    </div>
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
  {!! Form::close() !!}

@endsection()

