<?php
namespace App\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CrudFactory
{
    /** @var EntityManager  */
    private $em;
    /** @var  FormFactory */
    private $formFactory;
    /** @var  Request */
    private $request;
    /**
     * CrudFactory constructor.
     * @param $em EntityManager
     * @param $form FormFactory
     * @param $requestStack RequestStack
     */
    public function __construct($em, $form, $requestStack)
    {
        $this->em=$em;
        $this->formFactory=$form;
        $this->request=$requestStack->getCurrentRequest();
    }

    /**
     * @return CommentCrudService
     */
    public function  getCommentService()
    {
        return new CommentCrudService($this->em,$this->formFactory,$this->request);
    }

    /**
     * @return VideoGameCrudService
     */
    public function  getVideoGameService()
    {
        return new VideoGameCrudService($this->em,$this->formFactory,$this->request);
    }

    /**
     * @return ReviewCrudService
     */
    public function  getReviewService()
    {
        return new ReviewCrudService($this->em,$this->formFactory,$this->request);
    }

}