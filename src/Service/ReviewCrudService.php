<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 14.
 * Time: 23:57
 */

namespace App\Service;


use App\Entity\Review;
use App\Entity\VideoGame;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReviewCrudService extends CrudService implements IReviewCrudFactory
{
    /**
     * ReviewCrudService constructor.
     * @param $em
     * @param $form
     * @param $request
     */
    public function __construct($em, $form, $request)
    {
        parent::__construct($em, $form, $request);
    }

    /**
     * @inheritDoc
     */
    public function getRepo()
    {
        return $this->em->getRepository(Review::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllReviews()
    {
       return $this->getRepo()->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getAllReviewsByUser($user_id)
    {
        return $this->getRepo()->findBy(["owner"=>$user_id]);
    }

    /**
     * @inheritDoc
     */
    public function getReviewById($review_id)
    {
        $review = $this->getRepo()->find($review_id);
        if (!$review){
            throw new NotFoundHttpException("REVIEW NOT FOUND");
        }
        return $review;
    }

    /**
     * @inheritDoc
     */
    public function saveReview($review)
    {
        $this->em->persist($review);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function deleteReview($review_id)
    {
       $review = $this->getReviewById($review_id);
       $this->em->remove($review);
       $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getReviewForm($review)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $review);
        $form->add("title", TextType::class, [
            'required'=>true
        ]);
        $form->add("videogame", EntityType::class, [
            'class' => VideoGame::class,
            'choice_label'=>'name',
            'choice_value'=>'videogame_id'
        ]);
        $form->add("content", TextareaType::class, [
            'required'=>true
        ]);
        $form->add("rating", NumberType::class, [
            'required'=>true
        ]);
        $form->add("SAVE", SubmitType::class);
        return $form->getForm();
    }

}