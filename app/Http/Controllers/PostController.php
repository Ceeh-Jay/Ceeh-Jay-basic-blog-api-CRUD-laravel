<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = $user->id;
        $post->save();

        return response()->json($post, 201);
    }

    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $post = Post::find($id);
        if ($post->user_id != $user->id) {
            return response()->json(['error' => 'This post was made by another user'], 403);
        }

        if($request->has('title')){
            $post->title = $request->input('title');
        }

        if($request->has('content')){
            $post->content = $request->input('content');
        }

        $post->save();

        return response()->json($post, 200);
    }

    public function destroy($id){
        $user = JWTAuth::parseToken()->authenticate();

        $post = Post::find($id);
        if($post->user_id != $user->id) {
            return response()->json(['error' => 'You post was made by another user.'], 403);
        }

        $post->delete();

        return response()->json(['message'=> 'Post deleted successfully'], 200);
    }
}
