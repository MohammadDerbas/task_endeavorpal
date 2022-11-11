<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Auth;

class PostService
{
    /**
     * @var $postRepository
     */
    protected  $postRepository;

    /**
     * PostService constructor.
     *
     * @param PostRepository $postRepository
    */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;

    }

    /**
     * Delete post by postId.
     *
     * @param $postId
     * @return Post
     * @throws AuthenticationException
     */
    public function deleteById($postId)
    {
        $this->checkAuthintication($postId);
        DB::beginTransaction();

        try {
            $post = $this->postRepository->delete($postId);

        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('Unable to delete post data');
        }

        DB::commit();

        return $post;

    }

    /**
     * Get all post with paginate.
     *
     * @return Post
     */
    public function getAllWithPagination()
    {
       return $this->postRepository->getAllWithPagination();
          }

    /**
     * Get post by id.
     *
     * @param $id
     * @return Post
     */
    public function getById($id)
    {
        return $this->postRepository->getById($id);

    }


    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param $request
     * @param $postId
     * @return Post
     * @throws AuthenticationException
     */
    public function updatePost($request, $postId)
    {
        $request->validate(
            [
                'post_content'=>'required'
            ]
        );

            $this->checkAuthintication($postId);

            DB::beginTransaction();

        try {
            $post = $this->postRepository->update($request, $postId);
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('Unable to update post data');
        }

        DB::commit();
        return $post;

    }

    /**
     * Validate post data.
     * Store to DB if there are no errors.
     *
     * @param $request
     * @return Post
     */
    public function savePostData($request)
    {
        $userId=Auth::id();
        $request->validate(
            [


                'post_content'=>'required'
            ]
        );

        $result = $this->postRepository->save($request,$userId);
        return $result;
    }


    /**
     *  check if the post found or not and check if the user try to make any changes
     * to another post
     * @param $postId
     * @return void
     * @throws AuthenticationException
     *
     */
    private function checkAuthintication($postId){
        $userId = Auth::id();
        $postUser=$this->postRepository->getUserId_By_PostId($postId);
        if($postUser != $userId){
            throw new AuthenticationException();
        }
    }

    /**
     * check if the post found or not
     * it will be thrown an exception if not
     * @param $postId
     * @return void
     *
     */
    public static function postFound($postId){
        PostRepository::postFound($postId);
    }

    /**
     * postFoundOrNotAndReturnUserCreateThatPost.
     * @param $postId
     * @return void
     */
    public static function postFoundWithUserId($postId){
        return PostRepository::postFoundWithUserId($postId);
    }

}

