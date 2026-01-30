<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        return PostResource::collection(Post::with('author')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request ->validated();

        // return $data;

        $data ['author_id'] = 3;

        $post = Post::create($data);

        // return response()->json(new PostResource($post), 201);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)  //this will automatically fetchc the post by id
    {
        // return response()->json(new PostResource($post));
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post) //this will automatically fetchc the post by id
    {
        $data = $request -> validate([
            'title' => 'required|string|min:2',
            'body' => ['required', 'string', 'min:2']
        ]);

        $post -> update($data);
        // return response()->json(new PostResource($post));
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post) ////this will automatically fetchc the post by id
    {
        $post->delete();
        return response()->noContent();
    }
}
