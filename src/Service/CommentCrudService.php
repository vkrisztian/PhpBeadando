<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2018. 12. 14.
 * Time: 23:50
 */

namespace App\Service;


use App\Entity\Comment;
use App\Entity\VideoGame;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentCrudService extends CrudService implements ICommentCrudService
{

    /**
     * CommentCrudService constructor.
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
        return $this->em->getRepository(Comment::class);
    }

    /**
     * @inheritDoc
     */
    public function getAllCommentsForReview($review_id)
    {
        return $this->getRepo()->findBy(["review"=>$review_id]);
    }

    /**
     * @inheritDoc
     */
    public function getAllCommentsForUser($user_id)
    {
        return $this->getRepo()->findBy(["owner"=>$user_id]);
    }

    /**
     * @inheritDoc
     */
    public function getCommentById($comment_id)
    {
        $comment = $this->getRepo()->find($comment_id);
        if (!$comment){
            throw new NotFoundHttpException("COMMENT NOT FOUND");
        }
        return $comment;
    }

    /**
     * @inheritDoc
     */
    public function saveComment($comment)
    {
       $this->em->persist($comment);
       $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function deleteComment($comment_id)
    {
        $comment = $this->getCommentById($comment_id);
        $this->em->remove($comment);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getCommentForm($comment)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $comment);

        $form->add("content", TextareaType::class, [
            'required'=>true
        ]);
        $form->add("SAVE", SubmitType::class);
        return $form->getForm();
    }


}