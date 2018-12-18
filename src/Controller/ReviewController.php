<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 15.
 * Time: 16:05
 */

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Review;
use App\Service\ICommentCrudService;
use App\Service\IReviewCrudFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends Controller
{
    /**
     * @var IReviewCrudFactory
     */
    private $reviewService;

    /**
     * @var ICommentCrudService
     */
    private $commentServcie;




    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->reviewService=$container->get('app.reviews');
        $this->commentServcie=$container->get('app.comments');
    }

    /**
     * @param Request $request
     * @return mixed
     * @Route("/reviews", name="reviews")
     */
    public function listAction(Request $request) {

        $reviews = $this->reviewService->getAllReviews();
        $twigParams = array("reviews"=>$reviews);
        return $this->render('Review/reviews.html.twig', $twigParams);
    }


    /**
     * @Route("/reviewShow/{reviewId}/{userId}", name="reviewShow")
     */
    public function showReview(Request $request,$reviewId,$userId)
    {
        $review = $this->reviewService->getReviewById($reviewId);
        $comments = $this->commentServcie->getAllCommentsForReview($reviewId);
        $twigParams["review"] = $review;
        $twigParams["comments"] = $comments;
        $comment = new Comment();
        $user = $this->reviewService->getOwnerById($userId);
        $comment->setOwner($user);
        $review = $this->reviewService->getReviewById($reviewId);
        $comment->setReview($review);
        $form2 = $this->commentServcie->getCommentForm($comment);
        $twigParams["form2"] = $form2->createView();
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()){
            $this->commentServcie->saveComment($comment);
            $this->addFlash('notice', 'CommentAdded');
            $params['reviewId'] = $reviewId;
            $params['userId'] = $userId;
            return $this->redirectToRoute('reviewShow',$params);
        }

        return $this->render('Review/review.html.twig',$twigParams);

    }

    /**
     * @Route("/reviewedit/{userId}/{reviewId}", name="reviewedit")
     */
    public function editAction(Request $request,$userId, $reviewId=0) {
        if ($reviewId){
            $review = $this->reviewService->getReviewById($reviewId);
        } else {
            $review = new Review();
            $user = $this->reviewService->getOwnerById($userId);
            $review->setOwner($user);
        }
        $form = $this->reviewService->getReviewForm($review);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->reviewService->saveReview($review);
            $this->addFlash('notice', 'REVIEWS EDITED');
            return $this->redirectToRoute('reviews');
        }
        return $this->render('Review/editreview.html.twig',
            ["form"=>$form->createView()]);
    }

}