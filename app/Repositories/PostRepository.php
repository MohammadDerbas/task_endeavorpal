<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * PostRepository constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get all posts with comments
     *
     * @return Post $post
     */
    public function getAll()
    {
        return Post::with("comments")->get();
        //return Post::all();

    }
    /**
     * Get all posts with comments each paginate with the newest order
     *
     * @return Post $post
     */
    public function getAllWithPagination(){

        return Post::with
        (
            [
                'comments'=>function ($query)
                {
                    $query->paginate(2);
                }
            ]
        )
            -> orderBy("created_at","desc")
            -> paginate(2);
    }

    /**
     * Get post by id
     *
     * @param $id
     * @return Post
     */
    public function getById($id)
    {
         return Post::with
         (
             [
                 'comments'=>function ($query)
                 {
                     $query->paginate(2);
                 }
             ]
         )->get()->find($id);
    }

    /**
     * Save Post
     *
     * @param $data
     * @return Post
     */
    public function save($data,$userId)
    {
            return $this->post->create(
            [
                'user_id'=>$userId,
                'post_content'=>$data->post_content
            ]
        );
    }

    /**
     * Update Post if not found throw exception
     *
     * @param $data
     * @param $id
     * @return Post
     */
    public function update($request, $id)
    {

        $post = $this->post->findOrFail($id);
        $post->post_content = $request->post_content;
        $post->update();

        return $post;
    }


    /**
     * delete Post if not found throw exception
     *
     * @param $data
     * @return Post
     */
    public function delete($id)
    {

        $post = $this->post->findOrFail($id);
        $post->delete();

        return $post;
    }

    /**
     * @param $postId
     * @return Post['user_id']
     */
    public function getUserId_By_PostId($postId){
        $post = $this->post->findOrFail($postId);
        return $post->user_id;
    }

    /**
     * check if the post found or not
     * @param $postId
     * @return void
     */
    public static function postFound($postId){
       Post::findOrFail($postId);
    }

    /**
     * check if the post found or nor and return who create the post
     * @param $postId
     * @return Post['user_id']
     */
    public static function postFoundWithUserId($postId){
        $Post=Post::findOrFail($postId);
        return $Post->user_id;
    }


}
