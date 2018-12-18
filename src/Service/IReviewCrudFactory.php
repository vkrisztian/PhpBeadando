<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 14.
 * Time: 23:38
 */

namespace App\Service;


use App\Entity\Review;
use App\Entity\User;
use Symfony\Component\Form\FormInterface;

Interface IReviewCrudFactory
{
    /**
     * @return Review[]
     */
    public function getAllReviews();

    /**
     * @param $user_id
     * @return Review[]
     */
    public function getAllReviewsByUser($user_id);

    /**
     * @param $review_id
     * @return Review
     */
    public function getReviewById($review_id);

    /**
     * @param $review
     */
    public function saveReview($review);

    /**
     * @param $review_id
     */
    public function deleteReview($review_id);

    /**
     * @param $review
     * @return FormInterface
     */
    public function getReviewForm($review);

    /**
     * @param $userId
     * @return User
     */
    public function getOwnerById($userId);

}