<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = $request->user()->posts()->latest()->get();

        return response()->json([
            'data' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        // We use $request->user()->id to set user_id — never trust user input for this
        $post = Post::create([
            'user_id' => $request->user()->id,
            'title'   => $request->title,
            'body'    => $request->body,
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'data'    => $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        // Authorization check: only the owner can view their post
        // abort(403) returns a 403 Forbidden response
        if ($post->user_id !== $request->user()->id) {
            abort(403, 'You do not own this post.');
        }

        return response()->json([
            'data' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Authorization check
        if ($post->user_id !== $request->user()->id) {
            abort(403, 'You do not own this post.');
        }

        $request->validate([
            'title' => 'sometimes|string|max:255', // 'sometimes' = only validate if field is present
            'body'  => 'sometimes|string',
        ]);

        // update() only changes the fields you pass in
        $post->update($request->only(['title', 'body']));
        // only() ensures we don't accidentally update user_id or other fields

        return response()->json([
            'message' => 'Post updated successfully',
            'data'    => $post,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        // Authorization check
        if ($post->user_id !== $request->user()->id) {
            abort(403, 'You do not own this post.');
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
        ]);
    }
}
