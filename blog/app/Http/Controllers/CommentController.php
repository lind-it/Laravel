<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Exception;

class CommentController extends Controller
{
    function get(Request $request, $postId)
    {
        $comments = Comment::where(['post_id' => $postId])->get();

        $func = function($comment) use($request)
                {
                    $isAutor = $comment->user_name == $request->session()->get('userName') ? true
                                                                                            : false;

                    $comment->is_autor = $isAutor;
                    return $comment;
                };

        $comments = $comments->map($func);

        return $comments;
    }

    function create(Request $request)
    {
        $post = Post::findOrFail($request->postId);

        try
        {
            $comment = $post->comment()->create([
                'user_name' => $request->session()->get('userName'),
                'text' => $request->text,
            ]);
        }

        catch(Execption $e)
        {
            return response('fail', 500);
        }

        $comment->is_autor = true;
        return response($comment, 200);

    }

    function update(Request $request)
    {
        $post = Post::findOrFail($request->postId);

        try
        {
            $post->comment()
                 ->where(['id' => $request->commentId])
                 ->update([
                    'text' => $request->text
                 ]);
        }
        catch(Exception $e)
        {
            return response($e, 500);
        }

        return response('1', 200);
    }

    function delete(Request $request)
    {
        $post = Post::findOrFail($request->postId);
        $post->comment()->where([
                                'id' => $request->commentId,
                                'post_id' => $request->postId
                            ])->delete();

        return response('1', 200);
    }
}
