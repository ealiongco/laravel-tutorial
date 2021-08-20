@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    {{-- <form method="post" action="/posts">
        <input type="text" name="title" placeholder="Enter title here"><br/>
        <input type="text" name="content" placeholder="Enter short content here"><br>
        {{ csrf_field() }}
        <input type="submit" name="submit">
    </form> --}}

    {!! Form::open(['method'=>'POST', 'action'=>'App\Http\Controllers\PostsController@store', 'files'=>true]) !!}
    <div class="form-group">
        {!! Form::file('file', ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title', null, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('content', 'Content') !!}
        {!! Form::text('content', null, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Create Post',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@section('footer')