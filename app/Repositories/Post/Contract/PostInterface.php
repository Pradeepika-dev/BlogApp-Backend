<?php

namespace App\Repositories\Post\Contract;

use App\Http\Requests\PostRequest;
use App\Models\Post;

interface PostInterface
{
    public function getAllPosts();

    public function savePost(PostRequest $request, $id = null);

    public function getPostById($id);

    public function deletePost($id);
}