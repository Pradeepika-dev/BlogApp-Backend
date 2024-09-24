<?php

namespace App\Http\Controllers;

use App\Repositories\Post\Contract\PostInterface;
use App\Http\Requests\PostRequest;
use App\Models\Post;

class PostController extends Controller 
{
    protected $post;

    public function __construct(PostInterface $post)
    {
        $this->post = $post;
        // To apply santum middleware to all methods except index and show
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->post->getAllPosts();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        return $this->post->savePost($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->post->getPostById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, $id)
    { 
       return $this->post->savePost($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->post->deletePost($id);
    }
}
