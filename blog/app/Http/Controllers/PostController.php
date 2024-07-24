<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Exception;

class PostController extends Controller
{
    function show(Request $request, $id)
    {
        $post = Post::where([
                        'id' => $id
                    ])->firstOr(function() { abort(404); });

        $like = $post->like()->where([
                                'post_id' => $id,
                                'user_id' => $request->session()->get('userId')
                            ])->first();

        return view('post/post', ['post' => $post, 'like' => $like ?? '']);
    }

    function postList(Request $request)
    {
        $posts = Post::where([
            'autor_name' => $request->session()->get('userName')
        ])->get();

        return view('post/postList', ['posts' => $posts]);
    }

    function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            try
            {
                $post = Post::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'text' => $request->text,
                    'autor_name' => $request->session()->get('userName')
                ]);
            }

            catch(\Illuminate\Database\QueryException $e)
            {
                // получаем сообщение об ошибке
                $error = $e->getMessage();

                //ошибка not null violation
                if(str_contains($error, 'SQLSTATE[23502]'))
                {
                    $request->session()->flash('postError', 'пожалуйста, заполните все поля');
                    return redirect('/post/create');
                }

                //ошибка unique violation
                else if(str_contains($error, 'SQLSTATE[23505]'))
                {
                    $request->session()->flash('postError', 'Статья с таким заголовком уже существует');
                    return redirect('/post/create');
                }

                $request->session()->flash('error', $e->getMessage());
                return redirect('/post/create');
            }

            catch(Exception $e)
            {
                $request->session()->flash('postError', $e);
                redirect('/post/create');
            }

            return redirect('/post/show/' . $post->id);

        }
        return view('post/create');
    }


    function update(Request $request, $id)
    {
        //ищем пост
        $post = Post::findOrFail($id);

        if ($request->isMethod('put'))
        {
            try
            {
                //обновляем его
                $post->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'text' => $request->text,
                ]);

                return redirect('/post/show/' . $id);
            }
            catch(Exception $e)
            {
                //в случае ошибки, пернапр
                $request->session()->flush('updateError', 'Произошла ошибка');
                return redirect('/post/update/' . $id);
            }
        }


        return view('post/update', ['post' => $post]);
    }

    function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect('post/postList');
    }
}
