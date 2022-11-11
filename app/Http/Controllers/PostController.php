<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use Illuminate\Http\Response;
use App\Models\Post;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function PHPUnit\Framework\throwException;

class PostController extends Controller
{

    /**
     * @var postService
     */
    protected  $postService;

    /**
     * PostController Constructor
     *
     * @param PostService $postService
     *
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;


    }

    /**
     * Display a listing of posts with paginate of 2 in
     *  and comments with paginate of 2
     *
     * @return Response
     */
    public function index()
    {

        $posts=$this->postService->getAllWithPagination();

        $response=
            [
              'posts' => $posts
            ];
        return response($response,200);

    }

    /**
     * Store a newly created posts in storage.
     *Assign the user_id with the user that sign in
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $post=$this->postService->savePostData($request);
        $response=
            [
                'post' => $post
            ];
        return response($response,201);
    }

    /**
     * Display the specified post
     * and return  'post not found' if it is not found in the database.
     *
     * @param $postId
     * @return Response
     */
    public function show($postId)
    {
        $post=$this->postService->getById($postId);

        if(!$post){
            throw new NotFoundHttpException;
        }

      $response =
          [
              'post' => $post
          ];
      return response($response,200);


    }

    /**
     * Update the specified post in storage
     * and return  'post not found' if it is not found in the database.
     *if the user try to update post that he is not create it return unauthorized with 401 status
     * post_content parameter required
     * @param Request $request
     * @param  int  $postId
     * @return Response
     */
    public function update(Request $request, $postId)
    {
        $postWithUpdate=$this->postService->updatePost($request,$postId);

        $response =
            [
                'post' => $postWithUpdate
            ];
        return response($response,200);
    }

    /**
     * Remove the specified post from storage.
     * and return  'post not found' if it is not found in the database.
     *if the user try to delete post that he is not create it return unauthorized with 401 status
     * @param  int  $postId
     * @return Response
     */
    public function destroy($postId)
    {
        $post=$this->postService->deleteById($postId);
        if ($post){
            return response(
                [
                    'post'=>$post,
                    'massage' => 'post deleted success'
                ],
                410
            );
        }
        else
        {
            return response(
                [
                    'massage' => 'post deleted unsuccessful'
                ],
                500
            );
        }
    }


}
