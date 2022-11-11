<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Comments;

class CommentsRepository
{
    /**
     * @var Comments
     */
    protected $comments;

    /**
     * Comment Repository constructor.
     *
     * @param Comment $comments
     */
    public function __construct(Comment $comments)
    {
        $this->comments = $comments;
    }

    /**
     * Get all comments to the specified post
     * @param $postId
     * @return Comment
     */
    public function getPostComments($postId)
    {

        return $this->comments->where('post_id',$postId)->get();

    }


    /**
     * Get comment by id if not found throw exception
     *
     * @param $commentId
     * @return Comment
     */
    public function getById($commentId)
    {
      return $this->comments->findorFail($commentId);
    }

    /**
     * save Comment
     * @param $request
     * @param $userId
     * @param $postId
     * @return Comment
     */
    public function save($request,$userId,$postId)
    {
        return Comment::create(
        [
            'post_id' => $postId,
            'user_id' => $userId,
            'comment_content' => $request -> comment_content
        ]
    );
    }

    /**
     * Update Comment if found ,if not throw exception
     * @param $request
     * @param $commentId
     * @return Comment
     */
    public function update($request, $commentId)
    {

        $comment = $this->comments->findOrFail($commentId);
        $comment->comment_content = $request->comment_content;
        $comment->update();

        return $comment;
    }


    /**
     * delete Post
     *
     * @param $data
     * @return Comment
     */
    public function delete($id)
    {

        $comment = $this->comments->findOrFail($id);
        $comment->delete();

        return $comment;
    }

    public function getUserId_By_CommentId($commentId){
        $comment = $this->comments->findOrFail($commentId);
        return $comment->user_id;
    }

}
