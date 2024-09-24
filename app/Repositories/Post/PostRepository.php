<?php 

namespace App\Repositories\Post;

use App\Http\Requests\PostRequest;
use App\Repositories\Post\Contract\PostInterface;
use App\Traits\ApiResponse;
use App\Models\Post;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostInterface
{
    // Use ApiResponse Trait in this repository
    use ApiResponse;

    public function getAllPosts()
    {
        try {
            $posts = Post::with('user')->latest()->get();
            return $this->success("All Posts", $posts);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function savePost(PostRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            
            /* Check the post exists or not.
               If not exists create a new post.
               If exists update the post. 
            */            
            if($id) {
                $post = Post::find($id);
                if($id && !$post) {
                    return $this->error("No post with ID $id", 404);
                }else{
                    $post = $request->user()->posts()->find($id);
                    if($post) {
                        $post->update($request->all());
                    } else {
                        return $this->error("You are not authorized to update this post", 403);
                    }
                    }
                }else {
                    $post = $request->user()->posts()->create($request->all());
                }
            
            DB::commit();

            return $this->success(
                $id ? "Post updated"
                    : "Post created",
					['post' => $post, 'user'=>$post->user]
            );
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getPostById($id)
    {
        DB::beginTransaction();
        try {
            $post = Post::find($id);

            // Check the post 
            if($id && $post == null) return $this->error("No post with ID $id", 404);

            DB::commit();
            return $this->success("Post Detail", ['post' => $post, 'user'=>$post->user]);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deletePost($id)
    {
        DB::beginTransaction();
        try {
            $post = Post::find($id);

            // // Check the post exits or not
            if($id && $post == null) return $this->error("No post with ID $id", 404);

            $post->delete();

            DB::commit();
            return $this->success("Post deleted", 204);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
} 