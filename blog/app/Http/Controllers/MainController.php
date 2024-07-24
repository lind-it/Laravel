<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class MainController extends Controller
{
    function index()
    {

        $posts = Post::latest('updated_at')
                    ->limit(5)
                    ->get();

        // добваляем каждому посту состояние создано или обновлено
        $func = function($post)
                {
                    $state = $post->created_at == $post->updated_at ? 'Создано' 
                                                                    : 'Обновлено';
                    $post->state = $state;
                    return $post;
                };
        
        $posts = $posts->map($func);

        return view('main/index', ['posts' => $posts]);
    }
}
