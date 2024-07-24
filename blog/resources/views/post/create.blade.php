@extends('layouts.main')

@section('title', 'create post')

@section('body')

    @if(Session::has('postError'))
        <p style="color:red">{{ Session::get('postError') }}</p>
    @endif

    <form action="/post/create" method="post" class="p-5">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок:</label>
            <input class="form-control" id="title" name="title" placeholder="">
        </div>

        <div class="mb-3">
            <label for="text" class="form-label">Краткое описание</label>
            <textarea class="form-control" id="text" style="" name="description" rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label for="text" class="form-label">Текст поста</label>
            <textarea class="form-control" id="text" style="" name="text" rows="20" style="white-space: pre-wrap;"></textarea>
        </div>

        <button type="subbmit" class="btn btn-primary">Создать пост</button>

    </form>
@endsection