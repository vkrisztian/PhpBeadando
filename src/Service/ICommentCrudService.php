<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 14.
 * Time: 23:32
 */

namespace App\Service;


use App\Entity\Comment;
use Symfony\Component\Form\FormInterface;

interface ICommentCrudService
{
    /**
     * @param $review_id
     * @return Comment[]
     */
   public function getAllCommentsForReview($review_id);

    /**
     * @param $user_id
     * @return Comment[]
     */
   public function getAllCommentsForUser($user_id);

    /**
     * @param $comment_id
     * @return Comment
     */
   public function getCommentById($comment_id);

    /**
     * @param $comment
     */
   public function saveComment($comment);

    /**
     * @param $comment_id
     */
   public function deleteComment($comment_id);

    /**
     * @param $comment
     * @return FormInterface
     */
   public function getCommentForm($comment);
}