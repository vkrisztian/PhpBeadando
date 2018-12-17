<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 15.
 * Time: 16:05
 */

namespace App\Controller;


use App\Entity\Review;
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



    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->reviewService=$container->get('app.reviews');
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
     * @Route("/reviewShow/{reviewId}", name="reviewShow")
     */
    public function showReview(Request $request,$reviewId)
    {
        $review = $this->reviewService->getReviewById($reviewId);
        return $this->render('Review/review.html.twig',["review"=>$review]);

    }

    /**
     * @Route("/reviewedit/{reviewId}", name="reviewedit")
     */
    public function editAction(Request $request, $reviewId=0) {
        if ($reviewId){
            $review = $this->reviewService->getReviewById($reviewId);
        } else {
            $review = new Review();

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