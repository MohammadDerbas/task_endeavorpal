<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\CommentsRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Auth;

class CommentService
{
    /**
     * @var $commentsRepository
     */
    protected  $commentsRepository;

    /**
     * CommentService constructor.
     *
     * @param CommentsRepository $commentsRepository
     */
    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;

    }

    /**
     * Delete post by commentId.
     *
     * @param $postId
     * @param $commentId
     * @return Comment
     * @throws AuthenticationException
     */
    public function deleteById($postId,$commentId)
    {
        PostService::postFoundWithUserId($postId);
        $this->checkCommentFoundOrNotAndCheckAuthintication($commentId);
        DB::beginTransaction();

        try {
            $comment = $this->commentsRepository->delete($commentId);

        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('Unable to delete comment data');
        }

        DB::commit();

        return $comment;

    }

    /**
     * Get all comments with pagination.
     *
     *
     */
    public function getAllWithPagination($postId)
    {
        //check if the post is found or not
        PostService::postFound($postId);
        $comments=$this->commentsRepository->getPostComments($postId);


        //Takes a JSON encoded string and converts it into a PHP value.
        //convert Json array to array
        // because array slice take
        // a paremeter of an array not json array
        $commentsArray = json_decode($comments, true);
        //paginate the comments to page each has 2 comments
        $commentsWithPaginate = $this -> paginate($commentsArray,2);
        return $commentsWithPaginate;
    }

    /**
     * Get comment by commentId.
     *
     * @param $postId
     * @param $commentId
     * @return Comment
     */
    public function getById($postId,$commentId)
    {
        //check if post found or not
        PostService::postFound($postId);

        return $this->commentsRepository->getById($commentId);

    }


    /**
     * Update comment data
     * Store to DB if there are no errors.
     *
     * @param $request
     * @param $postId
     * @param $commentId
     * @return Comment
     * @throws AuthenticationException
     */
    public function updateComment($request, $postId,$commentId)
    {
        $request->validate(
            [
                'comment_content'=>'required'
            ]
        );
        //check post is found or not
        PostService::postFound($postId);
        $this->checkCommentFoundOrNotAndCheckAuthintication($commentId);

        DB::beginTransaction();

        try {
            $comment= $this->commentsRepository->update($request, $commentId);
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('Unable to update comment data');
        }

        DB::commit();
        return $comment;

    }

    /**
     * Validate comment data.
     * Store to DB if there are no errors.
     *
     * @param $request
     * @param $postId
     * @return Comment
     * @throws AuthenticationException
     */
    public function saveComment($request,$postId)
    {
        $request -> validate(
            [
                'comment_content'=>'required'
            ]
        );
        PostService::postFound($postId);
        $userId=Auth::id();



        $comment = $this->commentsRepository->save($request,$userId,$postId);
        return $comment;
    }





    /**
     * Paginate array to pages each have specific field
     *
     * @param array $items
     * @param int $perPage
     * @param  int $page
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 4, $page = null)
    {
        //if it gets from $page default it will be started from 1
        //else will be started from pagination from this $page
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        //total of array elements
        $total = count($items);
        $currentpage = $page;
        //calculate the offeset that the pagination reach
        $offset = ($currentpage * $perPage) - $perPage ;
        //get a slice from array from  offset to offset+perPage
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total ,$perPage);
    }

    /**
     * check if the comment found or not and check if the user try to make any changes
     * to another comment
     *
     * @param int $commentId
     * @throws AuthenticationException
     */
    private function checkCommentFoundOrNotAndCheckAuthintication($commentId)
    {
        $commentUser = $this->commentsRepository->getUserId_By_CommentId($commentId);

        $userId=Auth::id();
        if($commentUser != $userId){
          throw new AuthenticationException();

        }

    }

}

