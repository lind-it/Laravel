@extends('layouts.main')

@section('title', '' . $post->title .'')

@section('body')

<div class="container text-center">
    <div class="row">

        <div class="col w-50">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h3>{{ $post->title }}</h3>
                    </div>

                    <div class="col">

                    </div>

                    <div class="col">
                        Создано: {{ $post->created_at->format('d-m-Y') }}
                    </div>
                </div>
                <div class="border border-primary text-start text-wrap p-5 w-100" style="font-size: 20px;">
                    {{ $post->text }}
                </div>
            </div>

            <div class="row">
                <div class="col mt-5 border-top border-info w-50" >
                    <h5 class="mt-3">Комментарии</h5>

                    <form name="comment">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Текст комментария</label>
                            <textarea name="text" class="form-control" cols="1"></textarea>
                        </div>
                        <button id="com-send" class="btn btn-primary">Отправить</button>
                    </form>

                    <div id="comments">

                    </div>
                </div>

                <div class="col mt-2">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @if(!empty($like))
                            @if($like->like)
                                <button id="dislike" type="button" class="btn border-danger-subtle">-</button>
                                <div id="like-count" class="border border-secondary-subtle" style="width:70px;">{{ $post->getLikesCount() }}</div>
                                <button id="like" type="button" class="btn border-primary-subtle btn-primary">+</button>
                            @elseif(!$like->like)
                                <button id="dislike" type="button" class="btn border-danger-subtle btn-danger">-</button>
                                <div id="like-count" class="border border-secondary-subtle" style="width:70px;">{{ $post->getLikesCount() }}</div>
                                <button id="like" type="button" class="btn border-primary-subtle ">+</button>
                            @endif
                        @else
                            <button id="dislike" type="button" class="btn border-danger-subtle">-</button>
                            <div id="like-count" class="border border-secondary-subtle" style="width:70px;">{{ $post->getLikesCount() }}</div>
                            <button id="like" type="button" class="btn border-primary-subtle">+</button>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>



@endsection

@section('scripts')

<script src="{{ asset('js/post/comments.js') }}"></script>
<script src="{{ asset('js/post/likes.js') }}"></script>

@endsection
