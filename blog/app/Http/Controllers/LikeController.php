<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Exception;

class LikeController extends Controller
{
    function create(Request $request)
    {
        $post = Post::findOrFail($request->postId);

        try
        {
            $post->like()->create([
                'post_id' => $request->postId,
                'user_id' => $request->session()->get('userId'),
                'like' => $request->like
            ]);
        }
        catch(Exception $e)
        {
            return $e;
        }

        return response($post->getLikesCount(), 200);
    }

    function delete(Request $request)
    {
        $post = Post::findOrFail($request->postId);

        $post->like()->where([
                            'user_id' => $request->session()->get('userId'),
                            'post_id' => $request->postId
                        ])->delete();

        return response($post->getLikesCount(), 200);
    }
}
