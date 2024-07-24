@extends('layouts.main')


@section('title', 'Главная')

@section('body')

<h4>Последние статьи</h4>

<div class="container text-center w-100">

@foreach($posts as $post)
    <div class="border border-primary mt-5">
                <div class="row">
                    <div class="col">
                        <h3><a href="/post/show/{{$post->id}}">{{ $post->title }}</a></h3>
                    </div>
                    
                    <div class="col">
                        {{ $post->state }}: {{ $post->updated_at}}
                    </div>
                </div>
            
            <p class="text-wrap">{{ $post->description }}</p>
    </div>

@endforeach
</div>

@endsection