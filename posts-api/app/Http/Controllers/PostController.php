<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    // Fetches posts with a limit of 10 per page and formats them using the Resource
    public function index(): AnonymousResourceCollection
    {
        $posts = Post::latest()->paginate(10);
        
        return PostResource::collection($posts);
    }

    // Uses StorePostRequest for automatic validation, then creates the post
    public function store(StorePostRequest $request): PostResource
    {
        $post = Post::create($request->validated());

        return new PostResource($post);
    }

    // Uses Route Model Binding (Post $post) to automatically fetch the post by ID or return a 404
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    // Uses UpdatePostRequest for validation and Route Model Binding for fetching
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $post->update($request->validated());

        return new PostResource($post);
    }

    // Deletes the post and returns an empty 204 No Content response
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}