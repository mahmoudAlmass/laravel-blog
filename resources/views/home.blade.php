@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <a class="nav-link btn btn-warning d-block  p-2"  href='/posts/create'>Create Post +</a>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Your Blog posts :
                </div>
                @if(count($posts)>0)
                <table class='table table-striped'>
                    <tr>
                        <th>Title</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($posts as $post)
                    <tr>
                        <td>{{$post->title}}</td>
                        <td class="float-right"><a href='/posts/{{$post->id}}/edit' class='btn btn-success '>Edit</a></td>
                        <td>
                        {!!Form::open(['action'=>['postController@destroy',$post->id],'method'=>'POST','class'=>'float-right' ])!!}
                        {{Form::hidden('_method','DELETE')}}
                        {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
                        {!!Form::close()!!}
                        </td>
                    </tr>
                    @endforeach()
                </table>
                @else()
                <div class='card-body'>No posts yet</div>
                @endif()
            </div>
        </div>
    </div>
</div>
@endsection
