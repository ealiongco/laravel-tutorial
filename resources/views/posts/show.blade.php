@extends('layouts.app')

@section('content')
    <h1><a href="{{route('posts.edit', $post->id)}}">{{$post->title}}</a></h1>

    <div class="image-container">
        <img height="500" src="{{$post->path}}" alt="">
    </div>
@endsection