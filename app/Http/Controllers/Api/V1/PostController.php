<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $user = request()->user();

        $posts = $user->posts()->with('author')->paginate(10); // 👈 note the ()

        return PostResource::collection($posts);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request ->validated();

        // return $data;

        $data ['author_id'] = $request->user()->id;

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

        // $user = request()->user();
        // if ($user->id !== $post->author_id) {
        //     abort(403, 'Access denied');
        // }

        abort_if(Auth::id() !== $post->author_id, 403, 'Access denied');

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
