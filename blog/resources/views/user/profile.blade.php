@extends('layouts.main')

@section('title', 'profile')

@section('body')

<h1>Name: {{ $user->name }}</h1>
<a href="exit">Выход</a>

@endsection