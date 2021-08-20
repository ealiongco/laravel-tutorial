@extends('layouts.app')

@section('content')
    <h1>Edit Post - {{$post->title}}</h1>
    {{-- <form method="post" action="/posts/{{$post->id}}">
        <input type="hidden" name="_method" value="PUT">
        <input type="text" name="title" value="{{$post->title}}" placeholder="Enter title here"><br/>
        <input type="text" name="content" value="{{$post->content}}" placeholder="Enter short content here"><br>
        {{ csrf_field() }}
        <input type="submit" name="submit" value="UPDATE">
    </form>

    <form method="post" action="/posts/{{$post->id}}">
        {{ csrf_field() }}      
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" value="DELETE">
    </form> --}}
    <div class="form-group">
        {!! Form::model($post, ['method'=>'PATCH', 'action'=> ['App\Http\Controllers\PostsController@update', $post->id]]) !!}
        {!! Form::hidden('_method', 'PUT') !!}
        {{ csrf_field() }}
        {!! Form::label('title', "Title") !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
        <br>
        {!! Form::label('content', 'Content') !!}
        {!! Form::text('content', null, ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit('Update Post', ['class'=> 'btn btn-info']) !!}

    {!! Form::close() !!}

    </div>

    <div class="form-group">
        {!! Form::open(['method'=>'DELETE', 'action' => ['App\Http\Controllers\PostsController@destroy', $post->id]]) !!}
        {!! Form::submit('Delete Post', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
    
@endsection

@section('footer')