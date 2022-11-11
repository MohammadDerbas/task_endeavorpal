<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class CommentController extends Controller
{
    /**
     * @var postService
     */
    protected  $commentsService;

    /**
     * PostController Constructor
     *
     * @param CommentService $commentsService
     *
     */
    public function __construct(CommentService $commentsService)
    {
        $this->commentsService = $commentsService;


    }
    /**
     * Display comments of a specific posts with pagination.
     * @param int $postId
     * @return Response
     */
    public function index($postId)
    {
        $commentsWithPaginate= $this->commentsService->getAllWithPagination($postId);
        $response =
            [
            'comments' => $commentsWithPaginate
            ];
        return response($response,200);
    }


    /**
     * Store a new comments for a specific post in storage.
     * and return  'object not found' if it is not found in the database.
     * @param int $postId
     * @param Request $request
     * @return Response
     * @throws AuthenticationException
     */
    public function store(Request $request,$postId)
    {
        $comment=$this->commentsService->saveComment($request,$postId);
        $response =
            [
                'comment' => $comment
            ];
        return response($response,201);
    }

    /**
     * Display the specified comment for the specified post.
     * return  'post not found' if the specified post not found in the database.
     * return  'comment not found' if the specified comment not found in the database.
     * @param  int  $postId
     * @param  int  $commentId
     * @return Response
     */
    public function show($postId,$commentId)
    {
     $comment=$this->commentsService->getById($postId,$commentId);

        $response =
            [
                'comment' => $comment
            ];
        return response($response,200);

    }

    /**
     * Update the specified comment for the specified post in storage.
     * return  'post not found' if the specified post not found in the database.
     *return   'comment not found' if the specified comment not found in the database.
     * if the user try to update comment that he is not create...
     * it returns unauthorized with 401 status
     * @param Request $request
     * @param  int  $postId
     * @param  int  $commentId
     * @return Response
     */
    public function update(Request $request, $postId,$commentId)
    {
        $comment = $this->commentsService->updateComment($request,$postId,$commentId);
       $response =
            [
                'comment' => $comment
            ];
        return response($response,200);
    }

    /**
     * Remove the specified comment for the specified post from storage.
     * return  'post not found' if the specified post not found in the database.
     *return  'comment not found' if the specified comment not found in the database.
     * if the user try to update comment that he is not create...
     * it returns unauthorized with 401 status
     * @param  int  $postId
     * @param  int  $commentId
     * @return Response
     */
    public function destroy($postId,$commentId)
    {
       $comment=$this->commentsService->deleteById($postId,$commentId);
        if ($comment){
            return response(
                [
                    'comment' => $comment,
                    'massage' => 'comment deleted success'
                ],
                410
            );
        }
        else
        {
            return response(
                [
                    'massage' => 'comment deleted unsuccessful'
                ],
                500
            );
        }

    }
}
