<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        try {
            $posts = Post::all();

            return response()->json([
                'message' => 'Posts retrieved successfully',
                'posts' => $posts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve posts',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $post = Post::find($id);

        if(!$post) {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

        return response()->json($post, 200);

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);


        $post = Post::create($validated);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if(!$post) {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $post->update($validated);

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post,
        ], 200);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if(!$post) {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
            'post' => $post,
        ], 200);
    }
}
