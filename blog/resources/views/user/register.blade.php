@extends('layouts.main')

@section('title', 'register')

@section('body')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 p-4" style="background-color: #f0f5fe; border: 1px solid #c8d7ed; border-radius: 10px;">
            <form method="post" action="/user/register">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Введите ник</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name">
                </div>  
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Подтвердите пароль</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            </form>
            <p>Уже есть аккаунт? - <a href="/user/auth" class="link-primary">Войди!</a></p>

            @if (Session::has('error'))
                <p style="color:red">{{ Session::get('error') }}</p>
            @endif
        </div>
    </div>
</div>

@endsection