<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResourcce;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user = $request->user();
        $posts = Post::paginate($request->input('per_page'));
        return PostResourcce::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
        // return $request->all();
        $data = $request->validated();

        $post = Post::create($data);

        return new PostResourcce($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        abort_if(Auth::id() !== $post->author_id, 403, "Access Forbidden");

        return new PostResourcce($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        //
        $data = $request->validated();

        $post->update($data);

        return new PostResourcce($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return response()->noContent();
    }
}
