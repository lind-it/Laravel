@extends('layouts.main')

@section('title', 'update {{ $post->id}}')

@section('body')

    @if(Session::has('updateError'))
        <p style="color:red">{{ Session::get('postError') }}</p>
    @endif

    <form action="/post/update/{{ $post->id }}" method="post" class="p-5">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок:</label>
            <input class="form-control" id="title" name="title" placeholder="" value="{{ $post->title }}">
        </div>

        <div class="mb-3">
            <label for="text" class="form-label">Краткое описание</label>
            <textarea class="form-control" id="text" style="" name="description" rows="5">{{ $post->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="text" class="form-label">Текст поста</label>
            <textarea class="form-control" id="text" style="" name="text" rows="20" style="white-space: pre-wrap;">{{ $post->text }}</textarea>
        </div>

        <button type="subbmit" class="btn btn-primary">Обновить</button>

    </form>


@endsection