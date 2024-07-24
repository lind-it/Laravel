@extends('layouts.main')

@section('title', 'Список постов')

@section('body')

    <div class="container-fluid text-center w-100">
        <div class="container-fluid text-center">
            @foreach($posts as $post)

                <div class="border border-primary mt-5 w-50">
                    <h3>{{ $post->title }}</h3>
                    <p class="text-wrap">{{ $post->description }}</p>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a type="button" class="btn btn-primary" href="/post/show/{{ $post->id }}">Просмотреть</a>
                        <a type="button" class="btn btn-success" href="/post/update/{{ $post->id }}">Редактировать</a>
                        <a type="button" class="btn btn-danger" href="/post/delete/{{ $post->id }}">Удалить</a>
                    </div>
                </div>

            @endforeach
        </div>
    </div>


@endsection